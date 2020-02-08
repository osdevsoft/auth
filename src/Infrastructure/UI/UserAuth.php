<?php

namespace Osds\Auth\Infrastructure\UI;

use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;
use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

use Osds\Auth\Application\Auth\CheckIfServiceIsAuthenticatedApplication;
use Osds\Auth\Application\Auth\AuthenticateServiceApplication;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

use Osds\Auth\Application\Auth\AuthenticateUserApplication;
use Osds\Auth\Application\Auth\CheckIfUserIsAuthenticatedApplication;

class UserAuth
{
    private $session;
    private $outputRequest;

    public function __construct(
        SessionRepository $session,
        OutputRequest $outputRequest
    )
    {
        $this->session = $session;
        $this->outputRequest = $outputRequest;
    }
    
    ### Used in services
	public function getUserAuthToken($session, $email = null, $password = null, $service = 'backoffice')
    {
        $user = self::checkUserAuth($session, $service);
        if ($user != null) {
            return $user;
        }

        #not logged and not trying to log
        if ($email == null || $password == null) {
            return null;
        }

        #not authenticated yet. make request to get token
        $authApp = new AuthenticateUserApplication($this->outputRequest);
        $user = $authApp->execute($service, $email, $password);

        if ($user != null && isset($user['uuid'])) {

            $this->session->insert("{$service}_user_token", $user);

        }
        return $user;
    }

    public static function checkUserAuth($session, $service)
    {
        $checkApp = new CheckIfUserIsAuthenticatedApplication($session);
        $user = $checkApp->execute($service);
        return $user;
    }

}
