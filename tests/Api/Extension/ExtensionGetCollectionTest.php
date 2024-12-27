<?php

namespace App\Tests\Api\Extension;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use App\Tests\Story\ExtensionsStory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ExtensionGetCollectionTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_extensions_collection(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        ExtensionsStory::load();

        static::createClient()->request('GET', '/api/extensions', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context"   => "/api/contexts/Extension",
            "@id"        => "/api/extensions",
            "@type"      => "Collection",
            "member"     => [
                [
                    "@id"          => "/api/extensions/WAREHOUSE",
                    "@type"        => "Extension",
                    "description"  => "Place were you store stuff",
                    "id"           => "WAREHOUSE",
                    "is_updatable" => true,
                    "name"         => "Warehouse",
                ],
                [
                    "@id"          => "/api/extensions/PLOT",
                    "@type"        => "Extension",
                    "description"  => "A little plot where you can plan seed",
                    "id"           => "PLOT",
                    "is_updatable" => true,
                    "name"         => "Plot",
                ],
                [
                    "@id"          => "/api/extensions/ROBOTCHARGER",
                    "@type"        => "Extension",
                    "description"  => "It provide energy for your farm",
                    "id"           => "ROBOTCHARGER",
                    "is_updatable" => false,
                    "name"         => "Solar Panel",
                ],
                [
                    "@id"          => "/api/extensions/SOLARPANEL",
                    "@type"        => "Extension",
                    "description"  => "A basic robot charger",
                    "id"           => "SOLARPANEL",
                    "is_updatable" => true,
                    "name"         => "Robot Charger",
                ],
                [
                    "@id"          => "/api/extensions/TRANSFORMER",
                    "@type"        => "Extension",
                    "description"  => "Place where you can transform food in other type of food",
                    "id"           => "TRANSFORMER",
                    "is_updatable" => true,
                    "name"         => "Transformer",
                ],
            ],
            "totalItems" => 5,
        ]);
    }

    public function test_get_extensions_collection_without_token(): void
    {
        ExtensionsStory::load();

        static::createClient()->request('GET', '/api/extensions');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertJsonEquals([
            "@context" => "/api/contexts/Error",
            "@id" => "/api/errors/401",
            "@type" => "Error",
            "description" => "Full authentication is required to access this resource.",
            "detail" => "Full authentication is required to access this resource.",
            "status" => 401,
            "title" => "An error occurred",
            "type" => "/errors/401"
        ]);
    }
}