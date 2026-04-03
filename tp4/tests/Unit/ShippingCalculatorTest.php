<?php

namespace App\Tests\Unit;

use App\Repository\ShippingRateRepository;
use App\Service\ShippingCalculator;
use PHPUnit\Framework\TestCase;

/**
 * TP4 - Test unitaire du ShippingCalculator (version corrigée du TP1).
 * Sert de référence pour mesurer le temps d'exécution parallèle.
 */
class ShippingCalculatorTest extends TestCase
{
    private ShippingCalculator $calculator;

    protected function setUp(): void
    {
        $repository      = $this->createStub(ShippingRateRepository::class);
        $this->calculator = new ShippingCalculator($repository);
    }

    public function testColisLegerRetourneCinqEuros(): void
    {
        self::assertSame(5.00, $this->calculator->calculate(3.0));
    }

    public function testColisMoyenRetourneDixEuros(): void
    {
        self::assertSame(10.00, $this->calculator->calculate(7.5));
    }

    public function testColisLourdRetourneVingtEuros(): void
    {
        self::assertSame(20.00, $this->calculator->calculate(15.0));
    }

    public function testColisTresLourdRetourneCinquanteEuros(): void
    {
        self::assertSame(50.00, $this->calculator->calculate(40.0));
    }

    public function testPoidsNegatifLeveException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate(-1.0);
    }

    public function testPoidsNulLeveException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate(0.0);
    }

    public function testLimiteHautePremiereTranche(): void
    {
        self::assertSame(5.00, $this->calculator->calculate(5.0));
    }

    public function testLimiteBasseDerniereTranche(): void
    {
        self::assertSame(50.00, $this->calculator->calculate(30.1));
    }

    public function testCalculateFromDatabaseWithValidWeight(): void
    {
        $repository = $this->createMock(ShippingRateRepository::class);
        $calculator = new ShippingCalculator($repository);

        // Mock the findAllOrderedByWeight method with realistic shipping rates
        $rate1 = new \App\Entity\ShippingRate(5.00, 'Light package', 5.0);
        $rate2 = new \App\Entity\ShippingRate(10.00, 'Medium package', 10.0);
        $rate3 = new \App\Entity\ShippingRate(20.00, 'Heavy package', 30.0);
        $rate4 = new \App\Entity\ShippingRate(50.00, 'Very heavy package', null);

        $repository->method('findAllOrderedByWeight')
            ->willReturn([$rate1, $rate2, $rate3, $rate4]);

        self::assertSame(5.00, $calculator->calculateFromDatabase(3.0));
        self::assertSame(10.00, $calculator->calculateFromDatabase(7.5));
        self::assertSame(20.00, $calculator->calculateFromDatabase(15.0));
        self::assertSame(50.00, $calculator->calculateFromDatabase(40.0));
    }

    public function testCalculateFromDatabaseThrowsExceptionOnInvalidWeight(): void
    {
        $repository = $this->createStub(ShippingRateRepository::class);
        $calculator = new ShippingCalculator($repository);

        $this->expectException(\InvalidArgumentException::class);
        $calculator->calculateFromDatabase(0.0);
    }

    public function testCalculateFromDatabaseThrowsExceptionOnNegativeWeight(): void
    {
        $repository = $this->createStub(ShippingRateRepository::class);
        $calculator = new ShippingCalculator($repository);

        $this->expectException(\InvalidArgumentException::class);
        $calculator->calculateFromDatabase(-5.0);
    }

    public function testCalculateFromDatabaseThrowsExceptionWhenNoRates(): void
    {
        $repository = $this->createMock(ShippingRateRepository::class);
        $calculator = new ShippingCalculator($repository);

        $repository->method('findAllOrderedByWeight')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Aucune tranche tarifaire configurée.');
        $calculator->calculateFromDatabase(5.0);
    }
}
