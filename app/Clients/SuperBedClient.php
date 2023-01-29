<?php

namespace App\Clients;

use Illuminate\Support\Facades\Storage;

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

    public function delete() {

    }

    public function upload($file)
    {
        $url = 'https://api.superbed.cn/upload';
        $post = array(
            'token' => $this->token,
            'categories' => $this->category
        );

        // 通过链接上传
        // $post['src'] = 'https://ww1.sinaimg.cn/large/005YhI8igy1fv09liyz9nj30qo0hsn0e';
        // 通过文件上传
        if (class_exists('CURLFile')) {
            $post['file'] = new \CURLFile(realpath($file));
        } else {
            $post['file'] = '@' . realpath($file);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($curl);
        curl_close($curl);
        return json_decode($res, true);
    }

    public static function test()
    {
        $c = new static([
            'token' => env("SUPER_BED_TOKEN"),
            'category' => env("SUPER_BED_CATEGORY"),
            'url' => env("SUPER_BED_URL"),
        ]);

        $patch = Storage::disk('public')->path('images/2b0c65c4fc768a359efa674a40d38762.jpg');
//        dd($patch);
        $c->upload($patch);

    }


}
