<?php

use PHPUnit\Framework\TestCase;
require_once 'binPart.php';
require_once __DIR__ . '/vendor/autoload.php';

class BinPartTest extends TestCase
{

    public function testGeneratedCodesUniqueness()
    {
        $binPart = new BinPart();
        $iterations = 10_000;
        $codigosGerados = [];

        for ($i = 0; $i < $iterations; $i++) {
            $codigo = $binPart->gerarCodigoApostaTimestamp($i);
            if ($codigo === 0) {
                echo "Failed max retry at iteration: $i\n";
                break;
            }
            $codigosGerados[] = $codigo;
        }
        $this->assertEquals(4, strlen($codigo), "Generated code does not have the expected length.");
        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");

        $minFail = min($codigosGerados);
        $maxFail = max($codigosGerados);
        $avgFail = array_sum($codigosGerados) / count($codigosGerados);

        echo "Min iteration of fail: $minFail\n";
        echo "Max iteration of fail: $maxFail\n";
        echo "Average iteration of fail: $avgFail\n";
    }
}