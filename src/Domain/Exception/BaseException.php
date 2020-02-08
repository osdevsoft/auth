<?php

namespace Osds\Auth\Domain\Exception;

use Exception;
use Osds\DDDCommon\Infrastructure\Log\LoggerInterface;

abstract class BaseException extends Exception
{

    protected $logger;

    public function __construct()
    {
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setMessageAndCode(
        string $message = "",
        int $code = 0
    ) {
        $this->message = $message;
        $this->code = $code;
    }

    public function getResponse()
    {
        return [
            'error_code' => $this->getCode(),
            'error_message' => $this->getMessage()
        ];
    }
}
