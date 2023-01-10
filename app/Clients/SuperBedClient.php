<?php

namespace App\Clients;

class SuperBedClient extends Request
{

    public $config;
    public $token;
    public $category;

    public function __construct($config)
    {
        if (!$config || !isset($config['token']))
            throw new \Exception("错误的配置参数");

        $this->config = $config;
        $this->token = data_get($config, 'token');
        $this->category = data_get($config, 'category', '');
    }

    public function upload($file) {
        $res = $this->post("https://api.superbed.cn/upload", [
            'multipart' => [
                [
                    'name'     => 'body',
                    'contents' => json_encode(['name' => 'Test', 'country' => 'Deutschland']),
                    'headers'  => ['Content-Type' => 'application/json']
                ],
                [
                    'name'     => 'file',
                    'contents' => fopen('617103.mp4', 'r'),
                    'headers'  => ['Content-Type' => 'video/mp4']
                ],
            ],
        ]);
    }


}
