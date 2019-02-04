<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */

namespace Codex\Auth\Http\Controllers;


use Codex\Exceptions\Exception;
use Codex\Hooks;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    protected function getProvider($service)
    {
        $this->validateService($service);
        return codex()->auth()->getProvider($service);
    }

    public function redirect($service)
    {
        $this->validateService($service);
        session()->put('codex.auth.redirect_after_callback', session()->previousUrl());
        return codex()->auth()->redirect($service);
    }

    public function logout($service)
    {
        $this->validateService($service);
        codex()->auth()->logout($service);
        return redirect()->route('codex');
    }

    public function callback($service)
    {
        $this->validateService($service);
        $user     = codex()->auth()->callback($service);
        $response = redirect(codex()->url());
        $response = Hooks::waterfall('AuthController::callback', $response, [ $service, $user ]);
        return $response;
    }

    public function getProtected()
    {
        return response(view('codex-auth::protected')->render(), 403);
    }


    /**
     * getDriver method
     *
     * @param $name
     *
     * @return \Laravel\Socialite\Contracts\Provider|mixed
     */
    protected function validateService($name)
    {
        if ( ! array_key_exists($name, config('codex-auth.services', []))) {
            throw Exception::make($name);
        }
    }
}
