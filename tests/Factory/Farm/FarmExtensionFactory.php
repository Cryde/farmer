<?php

namespace App\Tests\Factory\Farm;

use App\Entity\Farm\FarmExtension;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<FarmExtension>
 */
final class FarmExtensionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return FarmExtension::class;
    }

    protected function defaults(): array
    {
        return [
            'creationDatetime' => self::faker()->dateTime(),
            'extension' => null, // TODO add App\Entity\Extension\Extension type manually
            'externalId' => self::faker()->text(255),
            'farm' => null, // TODO add App\Entity\Farm\Farm type manually
            'level' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FarmExtension $farmExtension): void {})
        ;
    }
}
