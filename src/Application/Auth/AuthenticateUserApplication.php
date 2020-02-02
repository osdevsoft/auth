<?php

namespace Osds\Auth\Application\Auth;

use Osds\DDDCommon\Infrastructure\Communication\OutputRequest;
use Symfony\Component\Console\Output\Output;

class AuthenticateUserApplication
{

    private $outputRequest;

    public function __construct(OutputRequest $outputRequest)
    {
        $this->outputRequest = $outputRequest;
    }

    public function execute($service, $email, $password)
    {

        $this->outputRequest->setQuery(
            'user',
            'get',
            ['get' =>
                ['search_fields[email]' => $email]
            ]
        );
        $response = $this->outputRequest->sendRequest();
        if($response !== null
            && isset($response['total_items'])
            && $response['total_items'] == 1
            && isset($response['items'][0]['password'])
            && password_verify($password, $response['items'][0]['password'])
        ) {
            return $response['items'][0];
        } else {
            return null;
        }
    }

}