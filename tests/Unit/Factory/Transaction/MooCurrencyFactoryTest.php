<?php

namespace App\Tests\Unit\Factory\Transaction;

use App\Factory\Transaction\MooCurrencyFactory;
use PHPUnit\Framework\TestCase;

class MooCurrencyFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $currency = MooCurrencyFactory::create();
        $this->assertSame('MOO', $currency->getCurrencyCode());
        $this->assertSame('Mooney', $currency->getName());
        $this->assertSame(0, $currency->getNumericCode());
        $this->assertSame(2, $currency->getDefaultFractionDigits());
    }
}