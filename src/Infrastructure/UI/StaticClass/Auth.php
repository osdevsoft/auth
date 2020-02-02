<?php

namespace Osds\Auth\Infrastructure\UI\StaticClass;

use Osds\Auth\Application\Auth\CheckIfUserIsAuthenticatedApplication;
use Osds\Auth\Application\Auth\AuthenticateServiceApplication;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;
use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

class Auth
{
    
    public static function getServiceAuthToken($username, $password, $service = 'api')
	{
	    $userKey = md5($username);
        $checkApp = new CheckIfUserIsAuthenticatedApplication();
        $serviceToken = $checkApp->execute($service, $userKey);
        if($serviceToken->get() != null) {
            return $serviceToken->get();
        }

        #not authenticated yet
	    $authApp = new AuthenticateServiceApplication();
	    $user = $authApp->execute($service, $username, $password);

	    if($user != null && isset($user['authToken'])) {
            
            $session = new SessionRepository();
            $session->insert("{$service}_service_token_{$userKey}", $user['authToken']);

            return new ServiceToken($user['authToken']);
        }

	    #TODO: die gracely
	    die('no service auth found');

	}

}
