<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

class CheckIfServiceIsAuthenticatedApplication
{

    private $session;

    public function __construct()
    {
        $this->session = new SessionRepository();
    }

    public function execute($service)
    {
        $this->session->delete("{$service}_service_token");
        $serviceToken = $this->session->find("{$service}_service_token");
        return new ServiceToken($serviceToken);
    }

}