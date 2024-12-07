<?php

namespace App\Tests\Api\Farmer\Get;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FarmerGetTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_farmer(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        $targetUser = FarmerFactory::createOne(['username' => 'TARGETUSER']);

        static::createClient()->request('GET', '/api/farmer/TARGETUSER', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context" => "/api/contexts/Farmer",
            "@id"      => "/api/farmer/TARGETUSER",
            "@type"    => "Farmer",
            "username" => "TARGETUSER",
        ]);
    }

    public function test_get_farmer_not_found(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        static::createClient()->request('GET', '/api/farmer/USERNOTFOUND', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/Error",
            "@id"         => "/api/errors/404",
            "@type"       => "Error",
            "description" => "Farmer not found",
            "detail"      => "Farmer not found",
            "status"      => 404,
            "title"       => "An error occurred",
            "type"        => "/errors/404",
        ]);
    }

    public function test_get_farmer_without_login(): void
    {
        static::createClient()->request('GET', '/api/farmer/no-login');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/Error",
            "@id"         => "/api/errors/401",
            "@type"       => "Error",
            "description" => "Full authentication is required to access this resource.",
            "detail"      => "Full authentication is required to access this resource.",
            "status"      => 401,
            "title"       => "An error occurred",
            "type"        => "/errors/401",
        ]);
    }
}