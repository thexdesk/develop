<?php


namespace Codex\Auth;


use Codex\Attributes\AttributeExtension;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeType as T;

class AuthAttributeExtension extends AttributeExtension
{

    public function register(AttributeDefinitionRegistry $registry)
    {

        $urls = $registry->codex->getChild('urls');
        $urls->child('auth_login_callback', T::STRING);
        $urls->child('auth_login', T::STRING);
        $urls->child('auth_logout', T::STRING);


        $projects = $registry->projects;
        $auth     = $projects->child('auth', T::MAP)->api('AuthConfig', [ 'new' ]);
        $auth->child('enabled', T::BOOL);
        $with = $auth->child('with', T::ARRAY(T::MAP))->noApi();
        $with->child('service', T::STRING);
        $with->child('groups', T::ARRAY(T::STRING));
        $with->child('emails', T::ARRAY(T::STRING));
        $with->child('usernames', T::ARRAY(T::STRING));
    }
}
