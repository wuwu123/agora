<?php

namespace Wu\Agora;

class Tool
{
    public static function packString($value)
    {
        return pack("v", strlen($value)) . $value;
    }
}
