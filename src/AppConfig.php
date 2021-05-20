<?php

namespace Wu\Agora;

class AppConfig
{
    /**
     * @var string
     */
    private $appID;

    /**
     * @var string
     */
    private $appCertificate;

    /**
     * @return string
     */
    public function getAppID(): string
    {
        return $this->appID;
    }

    /**
     * @param string $appID
     * @return AppConfig
     */
    public function setAppID(string $appID): AppConfig
    {
        $this->appID = $appID;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppCertificate(): string
    {
        return $this->appCertificate;
    }

    /**
     * @param string $appCertificate
     * @return AppConfig
     */
    public function setAppCertificate(string $appCertificate): AppConfig
    {
        $this->appCertificate = $appCertificate;
        return $this;
    }
}
