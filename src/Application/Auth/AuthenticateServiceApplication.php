<?php

namespace Osds\Auth\Application\Auth;

use Osds\Auth\Domain\User;
use Osds\Auth\Infrastructure\Persistence\DoctrineRepository;
use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;

class AuthenticateServiceApplication
{

    private $outputRequest;

    public function __construct()
    {
        $this->outputRequest = new OutputRequest('http://api.osdshub.sandbox/');
    }

    public function execute($service, $username, $password)
    {

        $this->outputRequest->setQuery(
            'apiServiceAuth', 
            'post',
            ['post' =>
                ['username' => $username,  'password' => $password]
            ]
        );
        $result = $this->outputRequest->sendRequest();
        return $result;
//        $user = $this->database->findBy(new User(), ['email' => $email]);
//        if ($user != null && password_verify($password, $user->getPassword())) {
//            $user->setIsLogged(true);
//            return $user;
//        } else {
//            return false;
//        }
    }

}