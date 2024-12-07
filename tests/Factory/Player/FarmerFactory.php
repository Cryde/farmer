<?php

namespace App\Tests\Factory\Player;

use App\Entity\Player\Farmer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Farmer>
 */
final class FarmerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Farmer::class;
    }

    protected function defaults(): array
    {
        return [
            'roles'    => [],
            'username' => self::faker()->text(180),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this// ->afterInstantiate(function(Farmer $farmer): void {})
            ;
    }
}
