<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

class CheckIfUserIsAuthenticatedApplication
{

    private $session;

    public function __construct(SessionRepository $session)
    {
        $this->session = $session;
    }

    public function execute($service)
    {
        $user = $this->session->find("{$service}_user_token");
        return $user;
    }

}