<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

class StoreServiceTokenApplication
{

    private $session;

    public function __construct(SessionRepository $session)
    {
        $this->session = $session;
    }

    public function execute($service, $token)
    {
        $this->session->insert("{$service}_service_token", $token);
    }

}