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

class SeedGetItemTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_seed_item(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        SeedsStory::load();

        static::createClient()->request('GET', '/api/seeds/TOMATO', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context" => "/api/contexts/Seed",
            "@id" => "/api/seeds/TOMATO",
            "@type" => "Seed",
            "id" => "TOMATO",
            "name" => "Tomato",
            "price" => 10
        ]);
    }

    public function test_get_seed_item_without_token(): void
    {
        static::createClient()->request('GET', '/api/seeds/TOMATO');
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