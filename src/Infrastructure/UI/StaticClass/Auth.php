<?php

namespace Osds\Auth\Infrastructure\UI\StaticClass;

use Osds\Auth\Application\User\AuthenticateUserApplication;
use Osds\Auth\Application\User\CheckIfAuthenticatedApplication;
use Osds\Auth\Infrastructure\Persistence\SessionRepository;

class Auth
{

	public static function authenticate($email, $password)
	{

	    $checkApp = new CheckIfAuthenticatedApplication();
	    $user = $checkApp->execute();

        if($user != null) {
            return 'already_logged';
        }

	    $authApp = new AuthenticateUserApplication();
	    $user = $authApp->execute($email, $password);

	    if($user != null) {

            $session = new SessionRepository();
            $session->put('user', $user);

            return 'login_ok';
        }

	    return 'login_ko';

	}

}
