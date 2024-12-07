<?php

namespace App\Tests\Factory\Security;

use App\Entity\Security\AccessToken;
use App\Tests\Factory\Player\FarmerFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<AccessToken>
 */
final class AccessTokenFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return AccessToken::class;
    }

    protected function defaults(): array
    {
        return [
            'expirationDatetime' => new \DateTime('+ 1 year'),
            'relatedFarmer'      => FarmerFactory::new(),
            'token'              => 'default_token',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this// ->afterInstantiate(function(AccessToken $accessToken): void {})
            ;
    }
}
