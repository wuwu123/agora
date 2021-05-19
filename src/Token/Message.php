<?php

namespace Wu\Agora\Token;

use Carbon\Carbon;

class Message
{
    public $salt;

    public $ts;
    /**
     * @var array
     */
    public $privileges;

    public function __construct()
    {
        $this->privileges = array();
    }

    public function packContent()
    {
        $this->salt = mt_rand(1, 99999999);
        $this->ts = Carbon::createFromTimestamp(time(), 'UTC')->timestamp;
        $buffer = unpack("C*", pack("V", $this->salt));
        $buffer = array_merge($buffer, unpack("C*", pack("V", $this->ts)));
        $buffer = array_merge($buffer, unpack("C*", pack("v", sizeof($this->privileges))));
        foreach ($this->privileges as $key => $value) {
            $buffer = array_merge($buffer, unpack("C*", pack("v", $key)));
            $buffer = array_merge($buffer, unpack("C*", pack("V", $value)));
        }
        return $buffer;
    }

    public function unpackContent($msg)
    {
        $pos = 0;
        $salt = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $ts = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $size = unpack("v", substr($msg, $pos, 2))[1];
        $pos += 2;

        $privileges = array();
        for ($i = 0; $i < $size; $i++) {
            $key = unpack("v", substr($msg, $pos, 2));
            $pos += 2;
            $value = unpack("V", substr($msg, $pos, 4));
            $pos += 4;
            $privileges[$key[1]] = $value[1];
        }
        $this->salt = $salt;
        $this->ts = $ts;
        $this->privileges = $privileges;
    }

    /**
     * @param $key
     * @param $expireTimestamp
     * @return $this
     */
    public function addPrivileges($key, $expireTimestamp): Message
    {
        $this->privileges[$key] = $expireTimestamp;
        return $this;
    }
}
