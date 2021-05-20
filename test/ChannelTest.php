<?php

namespace Test;

use Wu\Agora\Response;

class ChannelTest extends BaseTest
{
    public function testUserInfo()
    {
        $res = $this->getModel()->userStatus(123, "ky");
        $this->assertSame($res->errorCode, Response::SUCCESS);
    }

    public function testUserList()
    {
        $res = $this->getModel()->userList("ky");
        $this->assertSame($res->errorCode, Response::SUCCESS);
    }

    public function testChannelList()
    {
        $res = $this->getModel()->channelList(0, 10);
        $this->assertSame($res->errorCode, Response::SUCCESS);
    }
}
