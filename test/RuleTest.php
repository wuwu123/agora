<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Wu\Agora\Config;
use Wu\Agora\Response;
use Wu\Agora\Rule\Rule;

class RuleTest extends BaseTest
{
    public function testGet()
    {
        $response = $this->getModel()->info();
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testCreate()
    {
        $response = $this->getModel()->create(
            'ky',
            '',
            '',
            10,
            ['join_channel']
        );
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testUpdate()
    {
        $response = $this->getModel()->update(
            1,
            10
        );
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testDelete()
    {
        $response = $this->getModel()->delete(1);
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }
}
