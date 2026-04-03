<?php

namespace App\Tests\Unit;

use App\Entity\ShippingRate;
use PHPUnit\Framework\TestCase;

/**
 * TP4 - Tests unitaires pour l'entité ShippingRate
 * Augmente la couverture de code de l'entité ShippingRate
 */
class ShippingRateTest extends TestCase
{
    public function testConstructorWithMaxWeight(): void
    {
        $rate = new ShippingRate(10.0, 'Colis léger', 5.0);
        self::assertSame(10.0, $rate->getPrice());
        self::assertSame('Colis léger', $rate->getLabel());
        self::assertSame(5.0, $rate->getMaxWeightKg());
    }

    public function testConstructorWithoutMaxWeight(): void
    {
        $rate = new ShippingRate(50.0, 'Colis très lourd');
        self::assertSame(50.0, $rate->getPrice());
        self::assertSame('Colis très lourd', $rate->getLabel());
        self::assertNull($rate->getMaxWeightKg());
    }

    public function testGetIdReturnsNullForNewRate(): void
    {
        $rate = new ShippingRate(10.0, 'Test');
        self::assertNull($rate->getId());
    }

    public function testGetPriceReturnsCorrectPrice(): void
    {
        $rate = new ShippingRate(25.50, 'Standard');
        self::assertSame(25.50, $rate->getPrice());
    }

    public function testGetLabelReturnsCorrectLabel(): void
    {
        $rate = new ShippingRate(10.0, 'Express');
        self::assertSame('Express', $rate->getLabel());
    }

    public function testGetMaxWeightKgReturnsCorrectValue(): void
    {
        $rate = new ShippingRate(10.0, 'Test', 15.5);
        self::assertSame(15.5, $rate->getMaxWeightKg());
    }
}
