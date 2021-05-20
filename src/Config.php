<?php

namespace Wu\Agora;

use Carbon\Carbon;
use Wu\Agora\Exception\AgoraException;

class Config
{
    protected $appID;

    protected $appCertificate;

    protected $version = "006";

    /**
     * @var Carbon
     */
    public $date;

    protected $timeOut = 2;

    protected $handler;

    protected $retry = 1;

    public function __construct(string $appID = '', string $appCertificate = '')
    {
        $this->appID = $appID;
        $this->appCertificate = $appCertificate;
    }

    /**
     * @throws AgoraException
     */
    public function checkConfig()
    {
        if (! $this->appID) {
            throw new AgoraException("appID check failed, should be a non-empty string");
        }
        if (! $this->appCertificate) {
            throw new AgoraException("appCertificate check failed, should be a non-empty string");
        }
    }

    /**
     * @return string
     */
    public function getAppID(): string
    {
        return $this->appID;
    }

    /**
     * @return string
     */
    public function getAppCertificate(): string
    {
        return $this->appCertificate;
    }

    /**
     * @param string $appID
     * @return Config
     */
    public function setAppID(string $appID): Config
    {
        $this->appID = $appID;
        return $this;
    }

    /**
     * @param string $appCertificate
     * @return Config
     */
    public function setAppCertificate(string $appCertificate): Config
    {
        $this->appCertificate = $appCertificate;
        return $this;
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
    public function getVersion(): string
    {
        return $this->version;
    }

    public function getVersionLen(): int
    {
        return strlen($this->version);
    }

    public function getAppIdLen(): int
    {
        return strlen($this->appID);
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setHandler(?callable $handler)
    {
        $this->handler = $handler;
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
}
