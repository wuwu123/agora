<?php

namespace Test;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Wu\Agora\Config;
use Wu\Agora\Project\Project;

class BaseTest extends TestCase
{
    public function getConfig()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->safeLoad();
        return new Config($_ENV['APP_ID'], $_ENV['APP_KEY']);
    }

    public function getModel()
    {
        $class = static::class;
        if ($class == ProjectTest::class) {
            return new Project($this->getConfig());
        }
        return null;
    }
}
