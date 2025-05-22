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

    // $i is the number of the attempt
    function gerarCodigoApostaTimestamp($i = 0)
    {
        $maxAttempts = 100; // Prevent infinite loop
        $attempts = 0;

        // Get the current set of randParts from Redis
        do {
            $randByte = random_bytes(2);
            $randPart = str_pad(strtoupper(bin2hex($randByte)), 4, '0', STR_PAD_LEFT);
            $attempts++;
            $existentRand = $this->redis->sadd('randPart', $randPart, 5);
            if ($attempts > $maxAttempts) {
                throw new Exception("Unable to generate unique randPart after $maxAttempts attempts.");
            }
            if ($existentRand === 0) {
                if ($attempts >= 2) {
                    echo "ATTEMPT: $attempts at $i\n";
                }
                echo "Duplicate code retrying: $randPart at $i\n";
            }
        } while ($existentRand === 0);

        // Store as associative array for fast lookup
        return $randPart;
    }

    function resetRandPart()
    {
        $this->redis->delete('randPart');
    }
}