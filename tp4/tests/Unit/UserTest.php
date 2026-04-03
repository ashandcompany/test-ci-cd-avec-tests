<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * TP4 - Tests unitaires pour l'entité User
 * Augmente la couverture de code de l'entité User
 */
class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User('John Doe', 'john@example.com');
    }

    public function testUserConstructorWithValidData(): void
    {
        $user = new User('Jane Doe', 'jane@example.com');
        self::assertSame('Jane Doe', $user->getName());
        self::assertSame('jane@example.com', $user->getEmail());
    }

    public function testGetNameReturnsCorrectName(): void
    {
        self::assertSame('John Doe', $this->user->getName());
    }

    public function testGetEmailReturnsCorrectEmail(): void
    {
        self::assertSame('john@example.com', $this->user->getEmail());
    }

    public function testGetIdReturnsNullForNewUser(): void
    {
        self::assertNull($this->user->getId());
    }

    public function testAddLoyaltyPointsIncrementsBalance(): void
    {
        self::assertSame(0, $this->user->getLoyaltyPoints());
        $this->user->addLoyaltyPoints(100);
        self::assertSame(100, $this->user->getLoyaltyPoints());
    }

    public function testAddMultipleLoyaltyPointsAccumulates(): void
    {
        $this->user->addLoyaltyPoints(50);
        $this->user->addLoyaltyPoints(30);
        self::assertSame(80, $this->user->getLoyaltyPoints());
    }

    public function testAddNegativeLoyaltyPointsReducesBalance(): void
    {
        $this->user->addLoyaltyPoints(100);
        $this->user->addLoyaltyPoints(-25);
        self::assertSame(75, $this->user->getLoyaltyPoints());
    }

    public function testAddLoyaltyPointsThrowsExceptionOnNegativeResult(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Les points ne peuvent pas être négatifs.');
        $this->user->addLoyaltyPoints(-50);
    }
}
