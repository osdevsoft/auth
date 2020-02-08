<?php

namespace Osds\Auth\Application\Auth;

use GuzzleHttp\Client;

class AuthenticateServiceApplication
{

    public function __construct()
    {
    }

    public function execute($authServiceEndpoint, $email, $password, $originSite)
    {
        $client = new Client([
            'base_uri' => $authServiceEndpoint
        ]);
        $response = $client->request(
            'post',
            '/apiServiceAuth?originSite=' . $originSite,
            ['form_params' => [
                'email' => $email,
                'password' => $password
                ]
            ]
        );
        $data = json_decode($response->getBody(), true);
        return $data;
    }

}