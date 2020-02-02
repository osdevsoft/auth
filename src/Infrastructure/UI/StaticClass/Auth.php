<?php

namespace Osds\Auth\Infrastructure\UI\StaticClass;

use Osds\Auth\Application\Auth\CheckIfUserIsAuthenticatedApplication;
use Osds\Auth\Application\Auth\AuthenticateServiceApplication;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;
use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;
use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

class Auth
{

    public static function getServiceAuthToken($authService, $username, $password, $service = 'api')
	{
	    $userKey = md5($username);
        $checkApp = new CheckIfUserIsAuthenticatedApplication();
        $serviceToken = $checkApp->execute($service, $userKey);
        if($serviceToken->get() != null) {
            return $serviceToken->get();
        }

	    #TODO: meh...
	    $authService = str_replace('api/', '', $authService);
        #not authenticated yet. make request to get token
        $outputRequest = new OutputRequest(
            $authService,
            $username,
            $password
        );
	    $authApp = new AuthenticateServiceApplication($outputRequest);
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
