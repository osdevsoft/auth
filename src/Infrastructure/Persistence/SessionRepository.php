<?php

namespace Osds\Auth\Infrastructure\Persistence;

class SessionRepository
{

    public function __construct()
    {
        @session_start();
    }

    public function put($var, $value)
    {
        $_SESSION[$var] = $value;
    }

    public function get($var)
    {
        return (isset($_SESSION[$var]))?$_SESSION[$var]:null;
    }

    public function remove($var)
    {
        unset($_SESSION[$var]);
    }

}