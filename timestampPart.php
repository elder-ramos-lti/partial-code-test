<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'RedisClient.php';


class TimestampPart
{
    public $redis;

    public function __construct()
    {
        $this->redis = new RedisClient();
    }

    function gerarCodigoApostaTimestamp($ms)
    {
        $initialEpoch = 1420070400000; // 1 de janeiro de 2015
        $ms = (int) $ms ?? (int) (microtime(true) * 1000);
        $nowMs = $ms - $initialEpoch;
        
        $seconds = intdiv($nowMs, 1000);
        $timePart = strtoupper(
            str_pad(base_convert($seconds, 10, 36), 6, '0', STR_PAD_LEFT)
        );

        // Use sadd to Redis to ensure uniqueness
        $existentRand = $this->redis->sadd('timestampPart', $timePart);
        if ($existentRand === 0) {
            // If the code already exists, return false
            return false;
        }

        return $timePart;
    }

}