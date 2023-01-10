<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Request
{
    public $client = null;
    public $jar = null;

    public function getCookieJar()
    {
        return false;
    }

    public function createClient(): Client
    {
        $ip = long2ip(mt_rand());
        $jar = $this->getCookieJar();
        return new Client([
            'cookies' => $jar,
            'verify' => false,
            'http_errors' => false,
            'timeout' => 60,
            'headers' => [
                'CLIENT-IP' => $ip,
                'X-FORWARDED-FOR' => $ip,
                'X-Requested-With' => 'XMLHttpRequest',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36',
            ],
        ]);
    }

    /**
     * 获取 Client
     * @return Client
     */
    public function getClient($name = null): Client
    {
        if (!$this->client) {
            $this->client = $this->createClient();
        }

        return $this->client;
    }

    /**
     * @throws GuzzleException
     */
    public function get($url, $options = []): ResponseInterface
    {
        $client = $this->getClient();
        return $client->get($url, $options);
    }

    /**
     * @throws GuzzleException
     */
    public function post($url, $options): ResponseInterface
    {
        $client = $this->getClient();
        return $client->post($url, $options);
    }


}
