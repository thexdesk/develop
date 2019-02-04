<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

namespace Codex\Auth;

use Codex\Codex;
use Codex\Projects\Project;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Two\InvalidStateException;

class CodexAuth
{
    protected $users = [];

    /** @var \Laravel\Socialite\Contracts\Factory|\Laravel\Socialite\SocialiteManager */
    protected $social;

    /** @var \Codex\Codex */
    protected $codex;

    public function __construct(Codex $parent, Factory $social)
    {
        $this->codex  = $parent;
        $this->social = $social;
    }


    public function getProvider($service)
    {
        $config   = config('codex-auth.services.' . $service);
        $config['redirect'] = url()->route('codex.auth.login.callback', compact('service'), true);
        $provider = $this->social->buildProvider(
            config('codex-auth.providers.' . $config[ 'provider' ]),
            $config
        );
        return $provider;
    }


    public function redirect($service)
    {
        $provider = $this->getProvider($service);
        $with     = config("codex-auth.services.{$service}.with");
        $scopes   = config("codex-auth.services.{$service}.scopes");
        $provider->scopes($scopes)->with($with);
        return $provider->redirect();
    }

    public function callback($service)
    {
        $provider = $this->getProvider($service);
        $user     = $provider->user();
        $data = collect($user)->toArray();
        $this->logout($service);
        session()->put("codex.auth.logins.{$service}", $data);
        $data2 = session()->get("codex.auth.logins.{$service}");
        return $user;
    }

    public function logout($service)
    {
        session()->forget("codex.auth.logins.{$service}");
    }

    public function isLoggedIn($service = null)
    {
        return $service === null ? count(session()->get('codex.auth.logins', [])) > 0 : session()->has("codex.auth.logins.{$service}");
    }

    public function user($service)
    {
        return session()->get("codex.auth.logins.{$service}");
    }

    public function hasAccess(Project $project)
    {
        if ($project->attr('auth.enabled', false) !== true) {
            return true;
        }
        foreach ($project->attr('auth.with', []) as $with) {
            $service   = data_get($with, 'service');
            $groups    = data_get($with, 'groups', []);
            $emails    = data_get($with, 'emails', []);
            $usernames = data_get($with, 'usernames', []);
            if ( ! $this->isLoggedIn($service)) {
                continue;
            }
            try {
                $user = $this->user($service);
                if (in_array($user['email'], $emails, true)) {
                    return true;
                }
                if (in_array($user['nickname'], $usernames, true)) {
                    return true;
                }
            } catch (InvalidStateException $e) {

            }
        }
        return false;
    }
}
