<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Wu\Agora\Response;
use Wu\Agora\Tool;

class ProjectTest extends BaseTest
{
    public function testAll()
    {
        $model = $this->getModel();
        $response = $model->all();
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testInfo()
    {
        $model = $this->getModel();
        $response = $model->info('U70iHhc846i', 'ky');
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testStatus()
    {
        $model = $this->getModel();
        $response = $model->status('U70iHhc846i', rand(0, 1));
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testIp()
    {
        $model = $this->getModel();
        $response = $model->ipConfig('U70iHhc846i', '180.158.83.2', 8080);
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testUsage()
    {
        $model = $this->getModel();
        $response = $model->usage('U70iHhc846i', '2020-10-10', '2021-10-10', 'default');
        $this->assertSame($response->errorCode, Response::SUCCESS);
    }

    public function testCreate()
    {
        $model = $this->getModel();
        $response = $model->create("Ky");
        $this->assertTrue(Tool::value(function () use ($response) {
            $errorCode = $response->errorCode;
            if ($errorCode == Response::SUCCESS) {
                return true;
            }
            $errorMessage = $response->errMessage;
            if ($errorMessage == "Duplicate project name") {
                return true;
            }
            return false;
        }));
    }
}
