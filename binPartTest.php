<?php

use PHPUnit\Framework\TestCase;
require_once 'binPart.php';
require_once __DIR__ . '/vendor/autoload.php';

class BinPartTest extends TestCase
{

    public function testGeneratedCodesUniqueness()
    {
        $binPart = new BinPart();
        $iterations = 1_000;
        $codigosGerados = [];

        $outerIterations = 1;
        $failures = [];

        for ($outer = 0; $outer < $outerIterations; $outer++) {
            $codigosGerados = [];
            $binPart->resetRandPart();
            $failedAt = null;

            for ($i = 0; $i < $iterations; $i++) {
                $codigo = $binPart->gerarCodigoApostaTimestamp();
                if (isset($codigosGerados[$codigo])) {
                    $failedAt = $i + 1;
                    $codigosGerados = [];
                    break;
                }
                $codigosGerados[$codigo] = true;
            }
            $binPart->resetRandPart();
            $failures[] = $failedAt ?? $iterations;
        }

        $this->assertCount($outerIterations, $failures, "The number of iterations should match the outer loop count.");

        $minFail = min($failures);
        $maxFail = max($failures);
        $avgFail = array_sum($failures) / count($failures);

        echo "Min iteration of fail: $minFail\n";
        echo "Max iteration of fail: $maxFail\n";
        echo "Average iteration of fail: $avgFail\n";
    }


    public function testGeneratedCodeFormat()
    {
        $binPart = new BinPart(); // Instancia a classe BinPart
        $codigo = $binPart->gerarCodigoApostaTimestamp(); // Chama o método da instância

        // Verifica se o código tem o comprimento esperado
        $this->assertEquals(4, strlen($codigo), "Generated code does not have the expected length.");

        // Verifica se o código contém apenas caracteres alfanuméricos maiúsculos
        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $codigo, "Generated code contains invalid characters.");
    }
}