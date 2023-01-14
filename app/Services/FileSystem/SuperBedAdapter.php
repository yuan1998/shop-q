<?php

namespace App\Services\FileSystem;

use App\Clients\SuperBedClient;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;

class SuperBedAdapter extends AbstractAdapter
{

    public $config;
    public $client;

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new SuperBedClient($config);
    }

    public function write($path, $contents, Config $config)
    {
        dd('write', $path, $config, $contents);

    }

    public function writeStream($path, $resource, Config $config)
    {
        dd('writeStream', $path, $config, $resource);

        // TODO: Implement writeStream() method.
    }

    public function update($path, $contents, Config $config)
    {
        dd('update', $path, $config, $contents);
        // TODO: Implement update() method.
    }

    public function updateStream($path, $resource, Config $config)
    {
        dd('updateStream', $path, $config, $resource);

        // TODO: Implement updateStream() method.
    }

    public function rename($path, $newpath)
    {
        // TODO: Implement rename() method.
    }

    public function copy($path, $newpath)
    {
        // TODO: Implement copy() method.
    }

    public function delete($path)
    {
        // TODO: Implement delete() method.
    }

    public function deleteDir($dirname)
    {
        // TODO: Implement deleteDir() method.
    }

    public function createDir($dirname, Config $config)
    {
        // TODO: Implement createDir() method.
    }

    public function setVisibility($path, $visibility)
    {
        // TODO: Implement setVisibility() method.
    }

    public function has($path)
    {
        // TODO: Implement has() method.
    }

    public function read($path)
    {
        // TODO: Implement read() method.
    }

    public function readStream($path)
    {
        // TODO: Implement readStream() method.
    }

    public function listContents($directory = '', $recursive = false)
    {
        // TODO: Implement listContents() method.
    }

    public function getMetadata($path)
    {
        // TODO: Implement getMetadata() method.
    }

    public function getSize($path)
    {
        // TODO: Implement getSize() method.
    }

    public function getMimetype($path)
    {
        // TODO: Implement getMimetype() method.
    }

    public function getTimestamp($path)
    {
        // TODO: Implement getTimestamp() method.
    }

    public function getVisibility($path)
    {
        // TODO: Implement getVisibility() method.
    }
}
