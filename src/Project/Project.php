<?php

namespace Wu\Agora\Project;

use Wu\Agora\Http;

class Project extends Http
{
    /**
     * 创建项目
     * @param $name
     * @param bool $enableSignKey
     * @return \Wu\Agora\Response
     */
    public function create($name, $enableSignKey = true)
    {
        return $this->requestPost('/dev/v1/project', ['name' => $name, "enable_sign_key" => $enableSignKey]);
    }

    /**
     * 所有的项目
     * @return \Wu\Agora\Response
     */
    public function all()
    {
        return $this->requestGet('/dev/v1/projects');
    }

    /**
     * 制定项目
     * @param string $id
     * @param string $name
     * @return \Wu\Agora\Response
     */
    public function info(string $id, string $name)
    {
        return $this->requestGet('/dev/v1/project', [
            'id' => $id,
            'name' => $name,
        ]);
    }

    /**
     * @param string $id
     * @param int $status
     * @return \Wu\Agora\Response
     */
    public function status(string $id, int $status)
    {
        return $this->requestPost('/dev/v1/project_status', [
            'id' => $id,
            'status' => $status
        ]);
    }

    /**
     * ip 录制
     * @param string $id
     * @param string $ip
     * @return \Wu\Agora\Response
     */
    public function ipConfig(string $id, string $ip, int $post)
    {
        return $this->requestPost('/dev/v1/recording_config', [
            'id' => $id,
            'recording_server' => $ip . ":" . $post
        ]);
    }

    /**
     * 开启和关闭签名
     * @param string $id
     * @param bool $enable
     * @return \Wu\Agora\Response
     */
    public function signkey(string $id, bool $enable)
    {
        return $this->requestPost('/dev/v1/signkey', [
            'id' => $id,
            'enable' => $enable
        ]);
    }

    /**
     * 重制签名
     * @param string $id
     * @return \Wu\Agora\Response
     */
    public function resetSignkey(string $id)
    {
        return $this->requestPost('/dev/v1/reset_signkey', [
            'id' => $id,
        ]);
    }

    /**
     * 项目使用量
     * @param string $id
     * @param string $from_date
     * @param string $to_date
     * @param string $business
     * @return \Wu\Agora\Response
     */
    public function usage(string $project_id, string $from_date, string $to_date, string $business = 'default')
    {
        return $this->requestGet('/dev/v3/usage', [
            'project_id' => $project_id,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'business' => $business,
        ]);
    }
}
