<?php

require 'vendor/autoload.php';
use Predis\Client as PredisClient;

class RedisClient
{
    public $r;

    public function __construct()
    {
        $this->r = new PredisClient([
            'scheme' => 'tcp',
            'host' => 'localhost',
            'port' => 6379,
            'password' => '',
            'database' => 0,
        ]);
    }

    public function set($key, $value)
    {
        $this->r->set($key, $value);
    }

    public function get($key)
    {
        return $this->r->get($key);
    }

    public function delete($key)
    {
        $this->r->del($key);
    }

    public function exists($key)
    {
        return $this->r->exists($key);
    }

    public function sadd($key, $value, $ttl = 0)
    {
        $saddResult = $this->r->sadd($key, $value);
        $this->r->expire($key, $ttl);
        return $saddResult;
    }
}