<?php

namespace App\Services\FileSystem;

use App\Clients\SuperBedClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;

class SuperBedAdapter extends AbstractAdapter
{

    public $config;
    public $client;
    public $unknown = [];
    public $lastReturn = null;

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new SuperBedClient($config);
    }

    public function upload($path, $content, $is_stream = false)
    {
//        $originPath = $path;
//        $ext = pathinfo($path, PATHINFO_EXTENSION);
//        $ext = $ext ? ".$ext" : "";
//        $name = Str::uuid() . time() . $ext;
//        $path = "images/$name";

        if (Storage::disk('public')->put($path, $content)) {
            $path = Storage::disk('public')->path($path);
            $result = $this->client->upload($path);
            $err = data_get($result, 'err');
            if ($err !== 0) {
                $msg = data_get($result, 'msg', '上传图片失败,请检查接口');
                throw new \Exception($msg);
            }

            $this->lastReturn = $result;
            return $result;
        } else {
            throw new \Exception("保存文件错误");
        }
    }

    public function getUrl($path)
    {
        $res = $this->getLastReturn();
        return data_get($res,'url');
    }


    public function getLastReturn()
    {
        return $this->lastReturn;
    }

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        return $this->upload($path, $contents);
    }

    /**
     * Write a new file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, true);
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config)
    {
        return $this->upload($path, $contents);
    }

    /**
     * Update a file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, true);
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {
        throw new \BadFunctionCallException('暂不支持该操作');

        $path = $this->applyPathPrefix($path);
        $newpath = $this->applyPathPrefix($newpath);
        $error = $this->bucketManager->rename($this->bucketName, $path, $newpath);
        return $error == null ? true : false;
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        throw new \BadFunctionCallException('暂不支持该操作');

        $path = $this->applyPathPrefix($path);
        $newpath = $this->applyPathPrefix($newpath);
        $error = $this->bucketManager->copy($this->bucketName, $path, $this->bucketName, $newpath);
        return $error == null ? true : false;
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        return true;
        $this->applyPathPrefix($path);
        $error = $this->bucketManager->delete($this->bucketName, $path);
        return $error == null ? true : false;
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        return false;
        throw new \BadFunctionCallException('暂不支持该操作');

        $path = $this->applyPathPrefix($path);
        $stat = $this->bucketManager->stat($this->bucketName, $path);
        if ($stat[0] == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        throw new \BadFunctionCallException('暂不支持该操作');

        $path = $this->applyPathPrefix($path);
        list($fileInfo, $error) = $this->bucketManager->stat($this->bucketName, $path);
        if ($fileInfo) {
            return $fileInfo;
        } else {
            throw new FileNotFoundException('对应文件不存在');
        }
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {
        throw new \BadFunctionCallException('暂不支持该操作');

        return $this->bucketManager->listFiles($this->bucketName);
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        return $this->read($path);
    }

    /**
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['fsize'];
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['fileType'];
    }

    /**
     * Get the last modified time of a file as a timestamp.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        $fileInfo = $this->read($path);
        return $fileInfo['putTime'];
    }

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path)
    {
        throw new \BadFunctionCallException('暂不支持该操作');
    }
}
