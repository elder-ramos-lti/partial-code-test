<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'RedisClient.php';

class BinPart
{
    public $redis;

    public function __construct()
    {
        $this->redis = new RedisClient();
    }

    function gerarCodigoApostaTimestamp()
    {
        $maxAttempts = 100; // Prevent infinite loop
        $attempts = 0;

        // Get the current set of randParts from Redis
        $existentRand = $this->redis->get('randPart');
        if (is_string($existentRand) && !empty($existentRand)) {
            $existentRand = json_decode($existentRand, true);
        } else {
            $existentRand = [];
        }

        do {
            $randByte = random_bytes(2);
            $randPart = strtoupper(bin2hex($randByte));
            $attempts++;
            if ($attempts > $maxAttempts) {
                throw new Exception("Unable to generate unique randPart after $maxAttempts attempts.");
            }
        } while (isset($existentRand[$randPart]));

        // Store as associative array for fast lookup
        $existentRand[$randPart] = true;
        $this->redis->set('randPart', json_encode($existentRand));

        return str_pad($randPart, 4, '0', STR_PAD_LEFT);
    }

    function resetRandPart()
    {
        $this->redis->delete('randPart');
    }
}