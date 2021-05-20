<?php

namespace Wu\Agora;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;

class Http
{
    /**
     * @var Config
     */
    public $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function authorization()
    {
        $customerKey = $this->config->getCustomerKey();
        $customerSecret = $this->config->getCustomerSecret();
        $credentials = $customerKey . ":" . $customerSecret;
        return "Basic " . base64_encode($credentials);
    }

    /**
     * @return Client
     */
    public function client(): Client
    {
        return new Client(
            [
                'timeout' => $this->config->getTimeOut(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->authorization()
                ],
                'handler' => $this->config->getHandler(),
                'base_uri' => 'https://api.agora.io'
            ]
        );
    }

    public function requestGet($url, $data = []): Response
    {
        if ($data) {
            $data['query'] = $data;
        }
        return $this->request("get", $url, $data);
    }

    public function requestPost($url, $data = []): Response
    {
        if ($data) {
            $data['json'] = $data;
        }
        return $this->request("post", $url, $data);
    }

    public function requestPut($url, $data = []): Response
    {
        if ($data) {
            $data['json'] = $data;
        }
        return $this->request("put", $url, $data);
    }

    public function requestDelete($url, $data = []): Response
    {
        if ($data) {
            $data['json'] = $data;
        }
        return $this->request("delete", $url, $data);
    }

    protected function request($method, $url, $data = []): Response
    {
        $response = new Response();
        try {
            /*** @var ResponseInterface $request */
            $response->response = Tool::retry($this->config->getRetry(), function () use ($method, $url, $data) {
                return $this->client()->request($method, $url, $data);
            });
            $data = \GuzzleHttp\json_decode($response->response->getBody(), true);
            $response->errorCode = Response::SUCCESS;
            $response->data = $data;
        } catch (BadResponseException $e) {
            $response->response = $e->getResponse();
            $data = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents(), true);
            $response->errorCode = $data['statusCode'] ?? 400;
            $response->errMessage = $data['message'] ?? 'Not Found';
            $response->data = $data;
        } catch (\Throwable $e) {
            $response->errorCode = 500;
            $response->errMessage = $e->getMessage();
        }
        return $response;
    }
}
