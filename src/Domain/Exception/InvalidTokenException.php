<?php

namespace Osds\Auth\Domain\Exception;

use Osds\DDDCommon\Infrastructure\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class InvalidTokenException extends BaseException
{


    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setMessage($message, $error)
    {
        $this->logger->error($message, [$error->getFile(), $error->getLine()]);
        parent::setMessageAndCode($message, Response::HTTP_UNAUTHORIZED);
    }
    
}