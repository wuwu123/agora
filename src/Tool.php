<?php

namespace Wu\Agora;

use Carbon\Carbon;

class Tool
{
    /**
     * @param $value
     * @return string
     */
    public static function packString($value)
    {
        return pack("v", strlen($value)) . $value;
    }

    /**
     * @param $times
     * @param callable $callback
     * @param int $sleep
     * @return mixed
     * @throws \Throwable
     */
    public static function retry($times, callable $callback, int $sleep = 200)
    {
        beginning:
        try {
            return $callback();
        } catch (\Throwable $e) {
            if (--$times < 0) {
                throw $e;
            }
            if ($sleep) {
                usleep($sleep * 1000);
            }
            goto beginning;
        }
    }

    /**
     * @return Carbon
     */
    public static function time()
    {
        return Carbon::createFromTimestamp(time(), 'UTC');
    }

    public static function value(callable $fun)
    {
        return $fun();
    }
}
