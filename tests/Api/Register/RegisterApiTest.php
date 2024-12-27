<?php

namespace Api\Register;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\Extension\ExtensionRepository;
use App\Repository\Farm\FarmExtensionRepository;
use App\Repository\Security\AccessTokenRepository;
use App\Tests\Story\ExtensionsStory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class RegisterApiTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private AccessTokenRepository $accessTokenRepository;
    private ExtensionRepository $extensionRepository;
    private FarmExtensionRepository $farmExtensionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessTokenRepository = static::getContainer()->get(AccessTokenRepository::class);
        $this->extensionRepository = static::getContainer()->get(ExtensionRepository::class);
        $this->farmExtensionRepository = static::getContainer()->get(FarmExtensionRepository::class);
    }

    public function test_register(): void
    {
        ExtensionsStory::load();
        // pre-test
        $this->assertCount(0, $this->accessTokenRepository->findAll());
        $this->assertCount(5, $this->extensionRepository->findAll());
        $this->assertCount(0, $this->farmExtensionRepository->findAll());

        static::createClient()->request('POST', '/api/farmer/register', [
            'json' => [
                'username' => 'Howdie'
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context" => "/api/contexts/Register",
            "@id"      => "/api/farmer/register/HOWDIE",
            "@type"    => "Register",
            "farmer"   => [
                "@id" => "/api/farmer/HOWDIE",
                "@type"    => "Farmer",
                "username" => "HOWDIE",
            ],
            "farms" => [
                [
                    "@id" => "/api/farm/Howdie-FARM-1",
                    "@type" => "Farm",
                    "energy" => 0,
                    "extension_count" => 4,
                    "money" => 0,
                    "name" => "Howdie-FARM-1",
                    "size" => 0,
                    "water" => 0
                ]
            ],
            "token" => "dummy-access-token",
        ]);
        $this->assertCount(1, $this->accessTokenRepository->findAll());
        $this->assertCount(5, $this->extensionRepository->findAll());
        $this->assertCount(4, $this->farmExtensionRepository->findAll());
    }

    public function test_register_with_too_long_username(): void
    {
        // pre-test
        $this->assertCount(0, $this->accessTokenRepository->findAll());

        static::createClient()->request('POST', '/api/farmer/register', [
            'json' => [
                'username' => 'Toolongusernamedamnitslong'
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/ConstraintViolationList",
            "@id"         => "/api/validation_errors/d94b19cc-114f-4f44-9cc4-4138e80a87b9",
            "@type"       => "ConstraintViolationList",
            "description" => "username: This value is too long. It should have 25 characters or less.",
            "detail"      => "username: This value is too long. It should have 25 characters or less.",
            "status"      => 422,
            "title"       => "An error occurred",
            "type"        => "/validation_errors/d94b19cc-114f-4f44-9cc4-4138e80a87b9",
            "violations"  => [
                [
                    "code"         => "d94b19cc-114f-4f44-9cc4-4138e80a87b9",
                    "message"      => "This value is too long. It should have 25 characters or less.",
                    "propertyPath" => "username",
                ],
            ],
        ]);
        $this->assertCount(0, $this->accessTokenRepository->findAll());
    }

    public function test_register_with_too_small_username(): void
    {
        static::createClient()->request('POST', '/api/farmer/register', [
            'json' => [
                'username' => 'ab'
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/ConstraintViolationList",
            "@id"         => "/api/validation_errors/9ff3fdc4-b214-49db-8718-39c315e33d45",
            "@type"       => "ConstraintViolationList",
            "description" => "username: This value is too short. It should have 3 characters or more.",
            "detail"      => "username: This value is too short. It should have 3 characters or more.",
            "status"      => 422,
            "title"       => "An error occurred",
            "type"        => "/validation_errors/9ff3fdc4-b214-49db-8718-39c315e33d45",
            "violations"  => [
                [
                    "code"         => "9ff3fdc4-b214-49db-8718-39c315e33d45",
                    "message"      => "This value is too short. It should have 3 characters or more.",
                    "propertyPath" => "username",
                ],
            ],
        ]);
    }

    public function test_register_with_wrong_username(): void
    {
        static::createClient()->request('POST', '/api/farmer/register', [
            'json' => [
                'username' => 'Howdie__hello'
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/ConstraintViolationList",
            "@id"         => "/api/validation_errors/ba537051-1e30-41a2-a416-fe5491bcf354",
            "@type"       => "ConstraintViolationList",
            "description" => "username: This username \"Howdie__hello\" is not valid.",
            "detail"      => "username: This username \"Howdie__hello\" is not valid.",
            "status"      => 422,
            "title"       => "An error occurred",
            "type"        => "/validation_errors/ba537051-1e30-41a2-a416-fe5491bcf354",
            "violations"  => [
                [
                    "code"         => 'ba537051-1e30-41a2-a416-fe5491bcf354',
                    "message"      => "This username \"Howdie__hello\" is not valid.",
                    "propertyPath" => "username",
                ],
            ],
        ]);
    }
}