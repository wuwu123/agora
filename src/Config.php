<?php

namespace Wu\Agora;

use Carbon\Carbon;
use Wu\Agora\Exception\AgoraException;

class Config
{
    /**
     * @var string app区分
     */
    private $appSource = 'default';

    /**
     * @var AppConfig[] app 证书
     */
    private $appKeyArray = [];

    /**
     * @var string token版本
     */
    protected $version = "006";

    /**
     * @var string api管理key
     */
    protected $customerKey;

    /**
     * @var string api管理密钥
     */
    protected $customerSecret;

    /**
     * @var int api请求超时时间
     */
    protected $timeOut = 2;

    /**
     * @var int api请求重试次数
     */
    protected $retry = 1;

    /**
     * @var null guzzle请求handler
     */
    protected $handler;

    /**
     * @var int token 有效期
     */
    public $tokenExpired = 3600;


    public function __construct(string $appID = '', string $appCertificate = '', string $customerKey = '', string $customerSecret = '')
    {
        $appConfig = new AppConfig();
        if ($appID || $appCertificate) {
            $appConfig->setAppID($appID);
            $appConfig->setAppCertificate($appCertificate);
            $this->appKeyArray[$this->appSource] = $appConfig;
        }
        $this->customerKey = $customerKey;
        $this->customerSecret = $customerSecret;
    }

    /**
     * @throws AgoraException
     */
    public function checkConfig()
    {
        if (! $this->getAppID()) {
            throw new AgoraException("appID check failed, should be a non-empty string");
        }
        if (! $this->getAppCertificate()) {
            throw new AgoraException("appCertificate check failed, should be a non-empty string");
        }
    }

    /**
     * @return string
     */
    public function getAppID(): string
    {
        return $this->appKeyArray[$this->appSource]->getAppID();
    }

    /**
     * @return string
     */
    public function getAppCertificate(): string
    {
        return $this->appKeyArray[$this->appSource]->getAppCertificate();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Config
     */
    public function setVersion(string $version): Config
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerKey(): string
    {
        return $this->customerKey;
    }

    /**
     * @param string $customerKey
     * @return Config
     */
    public function setCustomerKey(string $customerKey): Config
    {
        $this->customerKey = $customerKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerSecret(): string
    {
        return $this->customerSecret;
    }

    /**
     * @param string $customerSecret
     * @return Config
     */
    public function setCustomerSecret(string $customerSecret): Config
    {
        $this->customerSecret = $customerSecret;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     * @return Config
     */
    public function setTimeOut(int $timeOut): Config
    {
        $this->timeOut = $timeOut;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetry(): int
    {
        return $this->retry;
    }

    /**
     * @param int $retry
     * @return Config
     */
    public function setRetry(int $retry): Config
    {
        $this->retry = $retry;
        return $this;
    }


    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param $handler
     * @return Config
     */
    public function setHandler($handler): Config
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppSource(): string
    {
        return $this->appSource;
    }

    /**
     * @param string $appSource
     * @return Config
     */
    public function setAppSource(string $appSource): Config
    {
        $this->appSource = $appSource;
        return $this;
    }

    /**
     * @return AppConfig[]
     */
    public function getAppKeyArray(): array
    {
        return $this->appKeyArray;
    }

    /**
     * @param AppConfig[] $appKeyArray
     * @return Config
     */
    public function setAppKeyArray(array $appKeyArray): Config
    {
        $this->appKeyArray = $appKeyArray;
        return $this;
    }

    public function getVersionLen()
    {
        return strlen($this->version);
    }

    public function getAppIdLen()
    {
        return strlen($this->getAppID());
    }

    /**
     * @return int
     */
    public function getTokenExpired(): int
    {
        return $this->tokenExpired;
    }

    /**
     * @param int $tokenExpired
     * @return Config
     */
    public function setTokenExpired(int $tokenExpired): Config
    {
        $this->tokenExpired = $tokenExpired;
        return $this;
    }
}
