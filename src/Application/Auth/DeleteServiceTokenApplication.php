<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;

class DeleteServiceTokenApplication
{

    private $session;

    public function __construct(SessionRepository $session)
    {
        $this->session = $session;
    }

    public function execute($service)
    {
        $this->session->delete("{$service}_service_token");
    }

}