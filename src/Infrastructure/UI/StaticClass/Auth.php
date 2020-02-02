<?php

namespace Osds\Auth\Infrastructure\UI\StaticClass;

use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;
use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

use Osds\Auth\Application\Auth\CheckIfServiceIsAuthenticatedApplication;
use Osds\Auth\Application\Auth\AuthenticateServiceApplication;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

use Osds\Auth\Application\Auth\AuthenticateUserApplication;
use Osds\Auth\Application\Auth\CheckIfUserIsAuthenticatedApplication;

class Auth
{

    public static function getServiceAuthToken($authService, $email, $password, $service = 'api')
	{
        $checkApp = new CheckIfServiceIsAuthenticatedApplication();
        $serviceToken = $checkApp->execute($service);
        if($serviceToken->get() != null) {
            return $serviceToken->get();
        }

        #not logged and not trying to log
        if($password == null) {
            return null;
        }
	    #TODO: meh...
	    $authService = str_replace('api/', '', $authService);
        #not authenticated yet. make request to get token
        $outputRequest = new OutputRequest(
            $authService,
            $email,
            $password
        );
	    $authApp = new AuthenticateServiceApplication($outputRequest);
	    $user = $authApp->execute($service, $email, $password);

	    if($user != null && isset($user['authToken'])) {
            
            $session = new SessionRepository();
            $session->insert("{$service}_service_token", $user['authToken']);

            return new ServiceToken($user['authToken']);
        }

	    #TODO: die gracely
	    die('no service auth found');

	}

	public static function getUserAuthToken($authService = null, $email = null, $password = null, $service = 'backoffice')
    {
        $checkApp = new CheckIfUserIsAuthenticatedApplication();
        $user = $checkApp->execute($service);
        if($user != null) {
            return $user;
        }

        #not logged and not trying to log
        if($email == null || $password == null) {
            return null;
        }
        #not authenticated yet. make request to get token
        $outputRequest = new OutputRequest(
            $authService,
            $email,
            $password
        );
        $authApp = new AuthenticateUserApplication($outputRequest);
        $user = $authApp->execute($service, $email, $password);

        if($user != null && isset($user['uuid'])) {

            $session = new SessionRepository();
            $session->insert("{$service}_service_token", $user);

            return $user;
        }

        #TODO: die gracely
        die('no user found');
    }


}
