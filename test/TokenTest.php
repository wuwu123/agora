<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Wu\Agora\Config;
use Wu\Agora\Token\AccessToken;
use Wu\Agora\Token\TokenBuilder;
use Wu\Agora\Tool;

class TokenTest extends BaseTest
{
    public function testCreate()
    {
        $channelName = "hdkhfdkasjhfakhf";
        $uidOrAccount = "1234567";
        $role = AccessToken::RoleAttendee;
        $time = Tool::time()->timestamp + 100;
        $tokenModel = new TokenBuilder($this->getConfig());
        $res = $tokenModel->buildToken($channelName, $uidOrAccount, $role, $time);
        $this->assertNotEmpty($res);

        $message = $tokenModel->messageByToken($res);
        $this->assertSame(4, count($message->privileges));
    }

    public function testRtmCreate()
    {
        $uidOrAccount = "1234567";
        $time = Tool::time()->timestamp + 100;
        $tokenModel = new TokenBuilder($this->getConfig());
        $res = $tokenModel->rtmTokenBuilder($uidOrAccount, $time);
        $this->assertNotEmpty($res);

        $message = $tokenModel->messageByToken($res);
        $this->assertSame(1, count($message->privileges));
    }
}
