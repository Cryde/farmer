<?php

namespace App\Tests\Factory\Seed;

use App\Entity\Seed\Seed;
use App\Factory\Transaction\MooCurrencyFactory;
use Brick\Money\Money;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Seed>
 */
final class SeedFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Seed::class;
    }

    protected function defaults(): array
    {
        return [
            'baseCostPrice' => Money::ofMinor(self::faker()->randomNumber(), MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(self::faker()->randomNumber(), MooCurrencyFactory::create()),
            'currencyCode' => self::faker()->text(10),
            'externalId' => self::faker()->text(255),
            'name' => self::faker()->text(255),
        ];
    }

    public function asTomato(): self
    {
        return $this->with([
            'name' => 'Tomato',
            'externalId' => 'TOMATO',
            'baseCostPrice' => Money::ofMinor(1000, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1500, MooCurrencyFactory::create()),
        ]);
    }

    public function asCarrot(): self
    {
        return $this->with([
            'name' => 'Carrot',
            'externalId' => 'CARROT',
            'baseCostPrice' => Money::ofMinor(500, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(2000, MooCurrencyFactory::create()),
        ]);
    }

    public function asPea(): self
    {
        return $this->with([
            'name' => 'Pea',
            'externalId' => 'PEA',
            'baseCostPrice' => Money::ofMinor(800, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1200, MooCurrencyFactory::create()),
        ]);
    }

    public function asCauliflower(): self
    {
        return $this->with([
            'name' => 'Cauliflower',
            'externalId' => 'CAULIFLOWER',
            'baseCostPrice' => Money::ofMinor(1200, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1800, MooCurrencyFactory::create()),
        ]);
    }

    public function asPumpkin(): self
    {
        return $this->with([
            'name' => 'Pumpkin',
            'externalId' => 'PUMPKIN',
            'baseCostPrice' => Money::ofMinor(1500, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1900, MooCurrencyFactory::create()),
        ]);
    }

    public function asPotato(): self
    {
        return $this->with([
            'name' => 'Potato',
            'externalId' => 'POTATO',
            'baseCostPrice' => Money::ofMinor(700, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1400, MooCurrencyFactory::create()),
        ]);
    }

    public function asOnion(): self
    {
        return $this->with([
            'name' => 'Onion',
            'externalId' => 'ONION',
            'baseCostPrice' => Money::ofMinor(900, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1600, MooCurrencyFactory::create()),
        ]);
    }

    public function asGarlic(): self
    {
        return $this->with([
            'name' => 'Garlic',
            'externalId' => 'GARLIC',
            'baseCostPrice' => Money::ofMinor(600, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1100, MooCurrencyFactory::create()),
        ]);
    }

    public function asBellPepper(): self
    {
        return $this->with([
            'name' => 'Bell Pepper',
            'externalId' => 'BELL_PEPPER',
            'baseCostPrice' => Money::ofMinor(1100, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1700, MooCurrencyFactory::create()),
        ]);
    }

    public function asSoy(): self
    {
        return $this->with([
            'name' => 'Soy',
            'externalId' => 'SOY',
            'baseCostPrice' => Money::ofMinor(1300, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(2000, MooCurrencyFactory::create()),
        ]);
    }

    public function asCucumber(): self
    {
        return $this->with([
            'name' => 'Cucumber',
            'externalId' => 'CUCUMBER',
            'baseCostPrice' => Money::ofMinor(800, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1400, MooCurrencyFactory::create()),
        ]);
    }

    public function asZucchini(): self
    {
        return $this->with([
            'name' => 'Zucchini',
            'externalId' => 'ZUCCHINI',
            'baseCostPrice' => Money::ofMinor(1000, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1800, MooCurrencyFactory::create()),
        ]);
    }

    public function asEggplant(): self
    {
        return $this->with([
            'name' => 'Eggplant',
            'externalId' => 'EGGPLANT',
            'baseCostPrice' => Money::ofMinor(700, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1300, MooCurrencyFactory::create()),
        ]);
    }

    public function asTurnip(): self
    {
        return $this->with([
            'name' => 'Turnip',
            'externalId' => 'TURNIP',
            'baseCostPrice' => Money::ofMinor(500, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(900, MooCurrencyFactory::create()),
        ]);
    }

    public function asStrawberry(): self
    {
        return $this->with([
            'name' => 'Strawberry',
            'externalId' => 'STRAWBERRY',
            'baseCostPrice' => Money::ofMinor(1500, MooCurrencyFactory::create()),
            'baseSalePrice' => Money::ofMinor(1900, MooCurrencyFactory::create()),
        ]);
    }

    protected function initialize(): static
    {
        return $this;
    }
}
