<?php

namespace Osds\Auth\Infrastructure\Coder;

interface CoderInterface
{
    public function encode($payload);
    
    public function decode($string);
}