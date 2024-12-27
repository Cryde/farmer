<?php

namespace App\Tests\Api\Farm\Get;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\Farm\FarmExtensionFactory;
use App\Tests\Factory\Farm\FarmFactory;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use App\Tests\Story\ExtensionsStory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FarmGetTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_farm(): void
    {
        ExtensionsStory::load();
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        FarmExtensionFactory::createOne(['extension' => ExtensionsStory::get('warehouse'), 'externalId' => 'ext_id_1', 'farm' => $farm, 'level' => 1,]);
        FarmExtensionFactory::createOne(['extension' => ExtensionsStory::get('plot'), 'externalId' => 'ext_id_2', 'farm' => $farm, 'level' => 1,]);
        FarmExtensionFactory::createOne(['extension' => ExtensionsStory::get('solarpanel'), 'externalId' => 'ext_id_3', 'farm' => $farm, 'level' => 1,]);
        FarmExtensionFactory::createOne(['extension' => ExtensionsStory::get('robotcharger'), 'externalId' => 'ext_id_4', 'farm' => $farm, 'level' => 1,]);


        static::createClient()->request('GET', '/api/farm/FARM-1', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context" => "/api/contexts/Farm",
            "@id" => "/api/farm/FARM-1",
            "@type" => "Farm",
            "energy" => 0,
            "extension_count" => 4,
            "money" => 0,
            "name" => "FARM-1",
            "size" => 0,
            "water" => 0
        ]);
    }

    public function test_get_farm_not_found(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        static::createClient()->request('GET', '/api/farm/FARM-NOT-FOUND', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/Error",
            "@id"         => "/api/errors/404",
            "@type"       => "Error",
            "description" => "Farm not found",
            "detail"      => "Farm not found",
            "status"      => 404,
            "title"       => "An error occurred",
            "type"        => "/errors/404",
        ]);
    }

    public function test_get_farm_without_login(): void
    {
        static::createClient()->request('GET', '/api/farm/no-login');
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