<?php

namespace App\Tests\Api\Market;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Enum\Transaction\TransactionType;
use App\Repository\Farm\FarmSeedRepository;
use App\Repository\Farm\FarmTransactionRepository;
use App\Tests\Factory\Farm\FarmFactory;
use App\Tests\Factory\Farm\FarmTransactionFactory;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use App\Tests\Story\SeedsStory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SeedBuyPostTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private FarmTransactionRepository $farmTransactionRepository;
    private FarmSeedRepository $farmSeedRepository;

    protected function setUp(): void
    {
        $this->farmTransactionRepository = static::getContainer()->get(FarmTransactionRepository::class);
        $this->farmSeedRepository = static::getContainer()->get(FarmSeedRepository::class);
        parent::setUp();
    }

    public function test_buy_seeds(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        FarmTransactionFactory::new()->asInitialTransaction($farm)->create();
        SeedsStory::load();

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());

        static::createClient()->request('POST', '/api/market/seeds', [
            'auth_bearer' => $token->getToken(),
            'json'        => [
                'farm'     => '/api/farm/' . $farm->getName(),
                'seed'     => '/api/seeds/TOMATO',
                'quantity' => 10,
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseIsSuccessful();

        $this->assertCount(2, $this->farmTransactionRepository->findAll());
        $results = $this->farmSeedRepository->findAll();
        $this->assertCount(1, $results);
        $this->assertSame('FARM-1', $results[0]->getRelatedFarm()->getName());
        $this->assertSame('Tomato', $results[0]->getSeed()->getName());
        $this->assertSame(10, $results[0]->getQuantity());
    }

    public function test_buy_seeds_with_existing_transaction_out(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        FarmTransactionFactory::new()->asInitialTransaction($farm)->create();
        FarmTransactionFactory::new()->asOutTransaction($farm, 3000, TransactionType::Seed)->create();
        SeedsStory::load();

        $this->assertCount(2, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());

        static::createClient()->request('POST', '/api/market/seeds', [
            'auth_bearer' => $token->getToken(),
            'json'        => [
                'farm'     => '/api/farm/' . $farm->getName(),
                'seed'     => '/api/seeds/TOMATO',
                'quantity' => 10,
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseIsSuccessful();

        $this->assertCount(3, $this->farmTransactionRepository->findAll());
        $results = $this->farmSeedRepository->findAll();
        $this->assertCount(1, $results);
        $this->assertSame('FARM-1', $results[0]->getRelatedFarm()->getName());
        $this->assertSame('Tomato', $results[0]->getSeed()->getName());
        $this->assertSame(10, $results[0]->getQuantity());
    }

    public function test_buy_seeds_with_too_much_quantity(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        FarmTransactionFactory::new()->asInitialTransaction($farm)->create();
        SeedsStory::load();

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());

        static::createClient()->request('POST', '/api/market/seeds', [
            'auth_bearer' => $token->getToken(),
            'json'        => [
                'farm'     => '/api/farm/' . $farm->getName(),
                'seed'     => '/api/seeds/TOMATO',
                'quantity' => 1000000,
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/ConstraintViolationList",
            "@id"         => "/api/validation_errors/0=5c03055b-810d-4f91-89e6-e1b2b29e0d54;1=d7422255-d2b9-47f5-827e-f841eeac7528",
            "@type"       => "ConstraintViolationList",
            "description" => "farm: You don't have enough mooney to buy seeds.\nquantity: You don't have enough space left in your warehouse to buy seeds.",
            "detail"      => "farm: You don't have enough mooney to buy seeds.\nquantity: You don't have enough space left in your warehouse to buy seeds.",
            "status"      => 422,
            "title"       => "An error occurred",
            "type"        => "/validation_errors/0=5c03055b-810d-4f91-89e6-e1b2b29e0d54;1=d7422255-d2b9-47f5-827e-f841eeac7528",
            "violations"  => [
                [
                    "code"         => "5c03055b-810d-4f91-89e6-e1b2b29e0d54",
                    "message"      => "You don't have enough mooney to buy seeds.",
                    "propertyPath" => "farm",
                ],
                [
                    "code"         => "d7422255-d2b9-47f5-827e-f841eeac7528",
                    "message"      => "You don't have enough space left in your warehouse to buy seeds.",
                    "propertyPath" => "quantity",
                ],
            ],
        ]);

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());
    }

    public function test_buy_seeds_with_farm_not_owned(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $user2 = FarmerFactory::createOne(['username' => 'user_login_2']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        $farm2 = FarmFactory::createOne(['relatedFarmer' => $user2, 'name' => 'FARM-2']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        FarmTransactionFactory::new()->asInitialTransaction($farm)->create();
        SeedsStory::load();

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());

        static::createClient()->request('POST', '/api/market/seeds', [
            'auth_bearer' => $token->getToken(),
            'json'        => [
                'farm'     => '/api/farm/' . $farm2->getName(),
                'seed'     => '/api/seeds/TOMATO',
                'quantity' => 1000000,
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonEquals([
            "@context" => "/api/contexts/ConstraintViolationList",
            "@id" => "/api/validation_errors/93460b11-66b4-403f-9b0a-a96a77b5ff94",
            "@type" => "ConstraintViolationList",
            "description" => "farm: You don't own the farm \"FARM-2\", so you can not do actions on it.",
            "detail" => "farm: You don't own the farm \"FARM-2\", so you can not do actions on it.",
            "status" => 422,
            "title" => "An error occurred",
            "type" => "/validation_errors/93460b11-66b4-403f-9b0a-a96a77b5ff94",
            "violations" => [
                [
                    "code" => "93460b11-66b4-403f-9b0a-a96a77b5ff94",
                    "message" => "You don't own the farm \"FARM-2\", so you can not do actions on it.",
                    "propertyPath" => "farm"
                ]
            ]
        ]);

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());
    }

    public function test_buy_seeds_not_logged(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        FarmTransactionFactory::new()->asInitialTransaction($farm)->create();
        SeedsStory::load();

        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());

        static::createClient()->request('POST', '/api/market/seeds', [
            'json'        => [
                'farm'     => '/api/farm/' . $farm->getName(),
                'seed'     => '/api/seeds/TOMATO',
                'quantity' => 10,
            ],
            'headers' => ['content-type' => 'application/ld+json']
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertCount(1, $this->farmTransactionRepository->findAll());
        $this->assertCount(0, $this->farmSeedRepository->findAll());
    }
}