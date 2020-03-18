<?php

namespace Osds\Auth\Infrastructure\Coder;

use \Firebase\JWT\JWT;

class JWTCoder implements CoderInterface
{
    #TODO: import from Src/$project/Infra/Auth/auth.keyfile for uniqueness per project
    private $key = 'Y2s|*3xvWUtkM=J|E>n7)wAM*zC<S9JcKpPE.Ht!KdBtImQeB\u%<,;NbP\2=lD';

    private $authTime = 86400; #one day

    public function encode($payload)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $this->authTime;
//        $payload['nbf'] = ; #Not allowed to be used BeFore specified date

        return JWT::encode($payload, $this->key);
    }

    public function decode($encoded, $force = false)
    {
        if($force) {
            #used for expired tokens
            JWT::$leeway = 991000;
        }
        return JWT::decode($encoded, $this->key, array('HS256'));
    }

}