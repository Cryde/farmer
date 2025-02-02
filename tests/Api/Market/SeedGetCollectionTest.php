<?php

namespace Api\Market;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use App\Tests\Story\ExtensionsStory;
use App\Tests\Story\SeedsStory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SeedGetCollectionTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_seed_collection(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        SeedsStory::load();

        static::createClient()->request('GET', '/api/market/seeds', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context"   => "/api/contexts/Seed",
            "@id"        => "/api/market/seeds",
            "@type"      => "Collection",
            "member"     => [
                [
                    "@id" => "/api/seeds/TOMATO",
                    "@type" => "Seed",
                    "id" => "TOMATO",
                    "name" => "Tomato",
                    "price" => 10,
                ],
                [
                    "@id" => "/api/seeds/CARROT",
                    "@type" => "Seed",
                    "id" => "CARROT",
                    "name" => "Carrot",
                    "price" => 5,
                ],
                [
                    "@id" => "/api/seeds/PEA",
                    "@type" => "Seed",
                    "id" => "PEA",
                    "name" => "Pea",
                    "price" => 8,
                ],
                [
                    "@id" => "/api/seeds/CAULIFLOWER",
                    "@type" => "Seed",
                    "id" => "CAULIFLOWER",
                    "name" => "Cauliflower",
                    "price" => 12,
                ],
                [
                    "@id" => "/api/seeds/PUMPKIN",
                    "@type" => "Seed",
                    "id" => "PUMPKIN",
                    "name" => "Pumpkin",
                    "price" => 15,
                ],
                [
                    "@id" => "/api/seeds/POTATO",
                    "@type" => "Seed",
                    "id" => "POTATO",
                    "name" => "Potato",
                    "price" => 7,
                ],
                [
                    "@id" => "/api/seeds/ONION",
                    "@type" => "Seed",
                    "id" => "ONION",
                    "name" => "Onion",
                    "price" => 9,
                ],
                [
                    "@id" => "/api/seeds/GARLIC",
                    "@type" => "Seed",
                    "id" => "GARLIC",
                    "name" => "Garlic",
                    "price" => 6,
                ],
                [
                    "@id" => "/api/seeds/BELL_PEPPER",
                    "@type" => "Seed",
                    "id" => "BELL_PEPPER",
                    "name" => "Bell Pepper",
                    "price" => 11,
                ],
                [
                    "@id" => "/api/seeds/SOY",
                    "@type" => "Seed",
                    "id" => "SOY",
                    "name" => "Soy",
                    "price" => 13,
                ],
                [
                    "@id" => "/api/seeds/CUCUMBER",
                    "@type" => "Seed",
                    "id" => "CUCUMBER",
                    "name" => "Cucumber",
                    "price" => 8,
                ],
                [
                    "@id" => "/api/seeds/ZUCCHINI",
                    "@type" => "Seed",
                    "id" => "ZUCCHINI",
                    "name" => "Zucchini",
                    "price" => 10,
                ],
                [
                    "@id" => "/api/seeds/EGGPLANT",
                    "@type" => "Seed",
                    "id" => "EGGPLANT",
                    "name" => "Eggplant",
                    "price" => 7,
                ],
                [
                    "@id" => "/api/seeds/TURNIP",
                    "@type" => "Seed",
                    "id" => "TURNIP",
                    "name" => "Turnip",
                    "price" => 5,
                ],
                [
                    "@id" => "/api/seeds/STRAWBERRY",
                    "@type" => "Seed",
                    "id" => "STRAWBERRY",
                    "name" => "Strawberry",
                    "price" => 15,
                ],
            ],
            "totalItems" => 15,
        ]);
    }

    public function test_get_seed_collection_without_token(): void
    {
        static::createClient()->request('GET', '/api/market/seeds');
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