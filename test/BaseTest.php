<?php

namespace Test;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Wu\Agora\Channel\Channel;
use Wu\Agora\Config;
use Wu\Agora\Project\Project;
use Wu\Agora\Rule\Rule;

class BaseTest extends TestCase
{
    public function getConfig()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->safeLoad();
        return new Config($_ENV['APP_ID'], $_ENV['APP_CERTIFICATE'], $_ENV['CUSTOMER_KEY'], $_ENV['CUSTOMER_SECRET']);
    }

    public function getModel()
    {
        $class = static::class;
        if ($class == ProjectTest::class) {
            return new Project($this->getConfig());
        }
        if ($class == RuleTest::class) {
            return new Rule($this->getConfig());
        }
        if ($class == ChannelTest::class) {
            return new Channel($this->getConfig());
        }
        return null;
    }
}
