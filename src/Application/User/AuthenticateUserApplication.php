<?php

namespace Osds\Auth\Application\User;

use Osds\Auth\Infrastructure\Persistence\DoctrineRepository;

class AuthenticateUserApplication
{

    private $database;

    public function __construct()
    {
        $this->database = new DoctrineRepository();
    }

    public function execute($email, $password)
    {

        $user = $this->database->findBy('User', ['email' => $email]);
        if($user != null && password_verify($password, $user->getPassword())) {
            $user->setIsLogged(true);
            return $user;
        } else {
            return false;
        }

    }

}