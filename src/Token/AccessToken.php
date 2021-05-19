<?php

namespace Wu\Agora\Token;

use Wu\Agora\Config;
use Wu\Agora\Exception\AgoraException;
use Wu\Agora\Tool;

class AccessToken
{
    public const Privileges = array(
        "kJoinChannel" => 1,
        "kPublishAudioStream" => 2,
        "kPublishVideoStream" => 3,
        "kPublishDataStream" => 4,
        "kPublishAudioCdn" => 5,
        "kPublishVideoCdn" => 6,
        "kRequestPublishAudioStream" => 7,
        "kRequestPublishVideoStream" => 8,
        "kRequestPublishDataStream" => 9,
        "kInvitePublishAudioStream" => 10,
        "kInvitePublishVideoStream" => 11,
        "kInvitePublishDataStream" => 12,
        "kAdministrateChannel" => 101,
        "kRtmLogin" => 1000,
    );

    public const RoleAttendee = 0;

    /**
     * 用户有发流权限
     */
    public const RolePublisher = 1;

    /**
     * 用户没有发流权限
     */
    public const RoleSubscriber = 2;

    public const RoleAdmin = 101;


    public const RoleRtmUser = 1;

    public $channelName;

    public $uid;

    /**
     * @var Message
     */
    public $message;

    /**
     * @var Config
     */
    public $config;

    /**
     * @param string $uid
     * @return $this
     */
    public function setUid(string $uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @param $channelName
     * @return $this
     */
    public function setChannelName($channelName)
    {
        $this->channelName = $channelName;
        return $this;
    }

    public static function make(Config $config, $message = null)
    {
        $accessToken = new AccessToken();
        $accessToken->config = $config;
        if (! ($message instanceof Message)) {
            $message = new Message();
        }
        $accessToken->message = $message;
        return $accessToken;
    }


    /**
     * @param Config $config
     * @param $token
     * @return Message
     * @throws AgoraException
     */
    public static function messageByToken(Config $config, $token)
    {
        $accessToken = new AccessToken();
        $accessToken->extract($config, $token);
        return $accessToken->message;
    }

    /**
     * 添加权限
     * @param $key
     * @param $expireTimestamp
     * @return $this
     */
    public function addPrivilege($key, $expireTimestamp): AccessToken
    {
        $this->message->addPrivileges($key, $expireTimestamp);
        return $this;
    }

    protected function extract(Config $config, $token)
    {
        $versionLen = $config->getVersionLen();
        $appidLen = $config->getAppIdLen();
        $version = substr($token, 0, $versionLen);
        if ($version !== $config->getVersion()) {
            throw new AgoraException('invalid version ' . $version);
        }
        $appid = substr($token, $versionLen, $appidLen);
        if ($appid != $config->getAppID()) {
            throw new AgoraException('invalid appid ' . $appid);
        }
        $content = (base64_decode(substr($token, $versionLen + $appidLen, strlen($token) - ($versionLen + $appidLen))));

        $pos = 0;
        $len = unpack("v", $content . substr($pos, 2))[1];
        $pos += 2;
        $sig = substr($content, $pos, $len);
        $pos += $len;
        $crc_channel = unpack("V", substr($content, $pos, 4))[1];
        $pos += 4;
        $crc_uid = unpack("V", substr($content, $pos, 4))[1];
        $pos += 4;
        $msgLen = unpack("v", substr($content, $pos, 2))[1];
        $pos += 2;
        $msg = substr($content, $pos, $msgLen);

        $message = new Message();
        $message->unpackContent($msg);
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function build()
    {
        $msg = $this->message->packContent();
        $val = array_merge(unpack("C*", $this->config->getAppID()), unpack("C*", $this->channelName), unpack("C*", $this->uid), $msg);

        $sig = hash_hmac('sha256', implode(array_map("chr", $val)), $this->config->getAppCertificate(), true);

        $crc_channel_name = crc32($this->channelName) & 0xffffffff;
        $crc_uid = crc32($this->uid) & 0xffffffff;

        $content = array_merge(unpack("C*", Tool::packString($sig)), unpack("C*", pack("V", $crc_channel_name)), unpack("C*", pack("V", $crc_uid)), unpack("C*", pack("v", count($msg))), $msg);
        return $this->config->getVersion() . $this->config->getAppID() . base64_encode(implode(array_map("chr", $content)));
    }
}
