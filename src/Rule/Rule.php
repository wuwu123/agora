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
        return $this->requestGet('/dev/v1/kicking-rule', ['appid' => $this->config->getAppID()]);
    }


    /**
     * 封禁用户权限
     * @param $cname
     * @param $uid
     * @param $ip
     * @param $timeSeconds
     * @param array $privileges [
     *  join_channel： 加入频道，表示禁止用户加入频道或将用户踢出频道。
     *  publish_audio：发送音频，表示禁止用户发送音频流。可以与 publish_video 同时设置，表示禁止用户发送音视流和视频流。
     *  publish_video：发送视频，表示禁止用户发送视频流。可以与 publish_audio 同时设置，表示禁止用户发送音视流和视频流。
     * ]
     * @return \Wu\Agora\Response
     */
    public function create($cname, $uid, $ip, $timeSeconds, array $privileges)
    {
        return $this->requestPost('/dev/v1/kicking-rule', [
            "appid" => $this->config->getAppID(),
            "cname" => $cname,
            "uid" => $uid,
            "ip" => $ip,
            "time_in_seconds" => $timeSeconds,
            "privileges" => $privileges
        ]);
    }

    /**
     * 更新封禁时间
     * @param int $ruleId 声网创建的ID
     * @param $timeSeconds
     * @return \Wu\Agora\Response
     */
    public function update(int $ruleId, $timeSeconds)
    {
        return $this->requestPut('/dev/v1/kicking-rule', [
            "appid" => $this->config->getAppID(),
            "id" => $ruleId,
            "time_in_seconds" => $timeSeconds,
        ]);
    }

    /**
     * 删除
     * @param int $ruleId 声网创建的ID
     * @return \Wu\Agora\Response
     */
    public function delete(int $ruleId)
    {
        return $this->requestDelete('/dev/v1/kicking-rule', [
            "appid" => $this->config->getAppID(),
            "id" => $ruleId,
        ]);
    }
}
