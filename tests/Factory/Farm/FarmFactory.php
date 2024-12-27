<?php

namespace App\Tests\Factory\Farm;

use App\Entity\Farm\Farm;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Farm>
 */
final class FarmFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Farm::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array
    {
        return [
            'creationDatetime' => self::faker()->dateTime(),
            'name' => self::faker()->text(255),
            'relatedFarmer' => null, // TODO add App\Entity\Player\Farmer type manually
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Farm $farm): void {})
        ;
    }
}
