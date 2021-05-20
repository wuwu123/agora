<?php

namespace Wu\Agora;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public const SUCCESS = 0;
    /**
     * @var ResponseInterface
     */
    public $response;

    public $errorCode;

    public $errMessage;

    public $data;
}
