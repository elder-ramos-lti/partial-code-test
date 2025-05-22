<?php

use PHPUnit\Framework\TestCase;
require_once 'timestampPart.php';
require_once __DIR__ . '/vendor/autoload.php';

class TimestampPartTest extends TestCase
{

    // public function testGeneratedCodeFormat()
    // {
    //     $now = (int) (microtime(true) * 1000);
    //     $timestampPart = new TimestampPart();
    //     $codigo = $timestampPart->gerarCodigoApostaTimestamp($now);

    //     $this->assertEquals(6, strlen($codigo), "Generated code does not have the expected length.");

    //     $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");
    // }

    public function testGeneratedCodesUniqueness()
    {
        $now = (int) (microtime(true) * 1000);
        $timestampPart = new TimestampPart();
        $iterations = 500_000_000;

        for ($i = 0; $i < $iterations; $i++) {
            $codigo = $timestampPart->gerarCodigoApostaTimestamp($now + ($i * 1000));
            if ($codigo === false) {
                // If the code already exists, break the loop
                echo "Duplicate code found at iteration: $i\n";
                $this->assertEquals(6, strlen($codigo), "Generated code does not have the expected length.");
                $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");
                break;
            }
            $this->assertEquals(6, strlen($codigo), "Generated code does not have the expected length.");
            $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");
        }
    }
}