<?php

namespace Api\Register;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class RegisterApiTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    // Todo : test username with special char (add those in regex!)

    public function test_register(): void
    {
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
            "token" => "dummy-access-token",
        ]);
    }

    public function test_register_with_too_long_username(): void
    {
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
}