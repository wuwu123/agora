<?php

namespace Wu\Agora;

use Carbon\Carbon;
use Wu\Agora\Exception\AgoraException;

class Config
{
    protected $appID;

    protected $appCertificate;

    protected $version = "006";

    public $date;

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
     */
    public function setAppID(string $appID): void
    {
        $this->appID = $appID;
    }

    /**
     * @param string $appCertificate
     */
    public function setAppCertificate(string $appCertificate): void
    {
        $this->appCertificate = $appCertificate;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return Carbon
     */
    public function getCarbon(): Carbon
    {
        return Carbon::createFromTimestamp(time(), 'UTC');
    }

    public function getVersionLen(): int
    {
        return strlen($this->version);
    }


    public function getAppIdLen(): int
    {
        return strlen($this->appID);
    }
}
