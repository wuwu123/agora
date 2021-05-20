<?php

namespace Wu\Agora\Channel;

use Wu\Agora\Http;

class Channel extends Http
{
    /**
     * @param int $uid
     * @param $channelName
     * @return \Wu\Agora\Response
     */
    public function userStatus(int $uid, $channelName)
    {
        $url = sprintf('/dev/v1/channel/user/property/%s/%d/%s', $this->config->getAppID(), $uid, $channelName);
        return $this->requestGet($url);
    }


    /**
     * @param $channelName
     * @return \Wu\Agora\Response
     */
    public function userList($channelName)
    {
        $url = sprintf('/dev/v1/channel/user/%s/%s', $this->config->getAppID(), $channelName);
        return $this->requestGet($url);
    }

    /**
     * 渠道列表
     * @param $page
     * @param $pageSize
     * @return \Wu\Agora\Response
     */
    public function channelList($page, $pageSize)
    {
        return $this->requestGet('/dev/v1/channel/' . $this->config->getAppID(), [
            'page_no' => $page,
            'page_size' => $pageSize,
        ]);
    }
}
