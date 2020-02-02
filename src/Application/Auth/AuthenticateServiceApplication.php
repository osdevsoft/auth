<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;
use Symfony\Component\Console\Output\Output;

class AuthenticateServiceApplication
{

    private $outputRequest;

    public function __construct(OutputRequest $outputRequest)
    {
        $this->outputRequest = $outputRequest;
    }

    public function execute($service, $email, $password)
    {

        $this->outputRequest->setQuery(
            'apiServiceAuth', 
            'post',
            ['post' =>
                ['email' => $email,
                 'password' => $password]
            ],
            [],
            false #no need for auth in this call
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