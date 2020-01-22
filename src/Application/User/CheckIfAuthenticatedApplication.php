<?php

namespace Osds\Auth\Application\User;

use Osds\Auth\Infrastructure\Persistence\SessionRepository;

class CheckIfAuthenticatedApplication
{

    private $session;

    public function __construct()
    {
        $this->session = new SessionRepository();
    }

    public function execute()
    {

        $user = $this->session->get('user');
        return $user;

    }

}