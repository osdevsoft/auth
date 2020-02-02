<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

class CheckIfUserIsAuthenticatedApplication
{

    private $session;

    public function __construct()
    {
        $this->session = new SessionRepository();
    }

    public function execute($service, $userKey)
    {
        $serviceToken = $this->session->find("{$service}_service_token_{$userKey}");
        return new ServiceToken($serviceToken);
    }

}