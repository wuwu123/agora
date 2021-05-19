<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Wu\Agora\Config;
use Wu\Agora\Token\AccessToken;
use Wu\Agora\Token\TokenBuilder;

class TokenTest extends TestCase
{
    /**
     * @return Config
     */
    public function getConfig()
    {
        return new Config('970CA35de60c44645bbae8a215061b33', '5CFd2fd1755d40ecb72977518be15d3b');
    }

    public function testCreate()
    {
        $config = $this->getConfig();
        $channelName = "hdkhfdkasjhfakhf";
        $uidOrAccount = "1234567";
        $role = AccessToken::RoleAttendee;
        $time = $config->getCarbon()->timestamp + 100;
        $tokenModel = new TokenBuilder($this->getConfig());
        $res = $tokenModel->buildToken($channelName, $uidOrAccount, $role, $time);
        $this->assertNotEmpty($res);

        $message = $tokenModel->messageByToken($res);
        $this->assertSame(4, count($message->privileges));
    }

    public function testRtmCreate()
    {
        $config = $this->getConfig();
        $uidOrAccount = "1234567";
        $time = $config->getCarbon()->timestamp + 100;
        $tokenModel = new TokenBuilder($this->getConfig());
        $res = $tokenModel->rtmTokenBuilder($uidOrAccount, $time);
        $this->assertNotEmpty($res);

        $message = $tokenModel->messageByToken($res);
        $this->assertSame(1, count($message->privileges));
    }
}
