<?php

namespace App\Tests\Api\Security;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LoginTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    // todo test with invalid token (expired etc.)
    public function test_login(): void
    {
        // We don't really test login we simply care that it pass or not
        $user = FarmerFactory::createOne(['username' => 'LOGIN']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        static::createClient()->request('GET', '/api/farmer/LOGIN', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function test_failed_login(): void
    {
        $user = FarmerFactory::createOne(['username' => 'LOGIN']);

        static::createClient()->request('GET', '/api/farmer/LOGIN', [
            'auth_bearer' => 'wrong-token',
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}