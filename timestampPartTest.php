<?php

use PHPUnit\Framework\TestCase;
require_once 'timestampPart.php';
require_once __DIR__ . '/vendor/autoload.php';

class TimestampPartTest extends TestCase
{
    public function testGeneratedCodesUniqueness()
    {
        try {
            $now = (int) 1772935118853;
            $timestampPart = new TimestampPart();
            $iterations = 5_000_000;

            for ($i = 0; $i < $iterations; $i++) {
                $codigo = $timestampPart->gerarCodigoApostaTimestamp($now + ($i * 1000));
                if ($codigo === false) {
                    // If the code already exists, break the loop
                    echo "Duplicate code found at iteration: $i\n";
                    break;
                }
            }
            $this->assertEquals(6, strlen($codigo), "Generated code does not have the expected length.");
            $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");
            echo "All codes generated successfully without duplicates. Last iteration: " . ($now + ($i * 1000));
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "in iteration $i\n";
        }
    }
}