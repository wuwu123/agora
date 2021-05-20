<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Wu\Agora\Config;
use Wu\Agora\Rule\Rule;

class RuleTest extends BaseTest
{
    public function testGet()
    {
        $rule = new Rule($this->getConfig());
        $rule->info();
        $this->assertEmpty(true);
    }
}
