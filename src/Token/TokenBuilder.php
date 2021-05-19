<?php

namespace Wu\Agora\Token;

use Wu\Agora\Config;

class TokenBuilder
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $channelName
     * @param $uidOrAccount
     * @param $role
     * @param $privilegeExpireTs
     * @return string
     */
    public function buildToken($channelName, $uidOrAccount, $role, $privilegeExpireTs): string
    {
        $Privileges = AccessToken::Privileges;
        $token = $this->newAccessToken($channelName, $uidOrAccount)->addPrivilege($Privileges["kJoinChannel"], $privilegeExpireTs);
        if (($role == AccessToken::RoleAttendee) || ($role == AccessToken::RolePublisher) || ($role == AccessToken::RoleAdmin)) {
            $token->addPrivilege($Privileges["kPublishVideoStream"], $privilegeExpireTs);
            $token->addPrivilege($Privileges["kPublishAudioStream"], $privilegeExpireTs);
            $token->addPrivilege($Privileges["kPublishDataStream"], $privilegeExpireTs);
        }
        return $token->build();
    }

    /**
     * @param $uidOrAccount
     * @param $privilegeExpireTs
     * @return string
     */
    public function rtmTokenBuilder($uidOrAccount, $privilegeExpireTs)
    {
        $Privileges = AccessToken::Privileges;
        $token = $this->newAccessToken($uidOrAccount, '');
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpireTs);
        return $token->build();
    }

    /**
     * @param $token
     * @return Message
     * @throws Exception\AgoraException
     */
    public function messageByToken($token): Message
    {
        return AccessToken::messageByToken($this->config, $token);
    }

    /**
     * @return AccessToken
     */
    protected function newAccessToken($channelName, $uidOrAccount)
    {
        $token = AccessToken::make($this->config);
        $token->setChannelName($channelName)->setUid($uidOrAccount);
        return $token;
    }

    /**
     * 设置权限的时间
     * @param $channelName
     * @param $uidOrAccount
     * @param $joinChannel
     * @param $pubAudio
     * @param $pubVideo
     * @param $pubData
     * @return string
     */
    public function buildTokenPrivilege($channelName, $uidOrAccount, $joinChannel, $pubAudio, $pubVideo, $pubData)
    {
        $Privileges = AccessToken::Privileges;
        $token = $this->newAccessToken($channelName, $uidOrAccount);
        $token->addPrivilege($Privileges["kJoinChannel"], $joinChannel);
        $token->addPrivilege($Privileges["kPublishAudioStream"], $pubAudio);
        $token->addPrivilege($Privileges["kPublishVideoStream"], $pubVideo);
        $token->addPrivilege($Privileges["kPublishDataStream"], $pubData);
        return $token->build();
    }
}
