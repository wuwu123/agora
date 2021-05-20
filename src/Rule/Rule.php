<?php

namespace Wu\Agora\Rule;

use Wu\Agora\Http;

class Rule extends Http
{
    /**
     * 封禁
     */
    public function info()
    {
        $this->request(
            'get',
            '/dev/v1/kicking-rule',
            ['appid' => $this->config->getAppID()]
        );
    }


    public function create()
    {
    }
}
