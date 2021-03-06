<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

class CheckIfServiceIsAuthenticatedApplication
{

    private $session;

    public function __construct(SessionRepository $session)
    {
        $this->session = $session;
    }

    public function execute($service)
    {
        $serviceToken = $this->session->find("{$service}_service_token");
        return new ServiceToken($serviceToken);
    }

}