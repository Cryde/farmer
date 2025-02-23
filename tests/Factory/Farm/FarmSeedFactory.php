<?php

namespace App\Tests\Factory\Farm;

use App\Entity\Farm\FarmSeed;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<FarmSeed>
 */
final class FarmSeedFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return FarmSeed::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'creationDatetime' => self::faker()->dateTime(),
            'quantity' => self::faker()->randomNumber(),
            'relatedFarm' => null,
            'seed' => null,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FarmSeed $farmSeed): void {})
        ;
    }
}
