<?php

namespace Api\Transaction\GetCollection;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Enum\Transaction\TransactionDirection;
use App\Enum\Transaction\TransactionType;
use App\Factory\Transaction\MooCurrencyFactory;
use App\Tests\Factory\Farm\FarmFactory;
use App\Tests\Factory\Farm\FarmTransactionFactory;
use App\Tests\Factory\Player\FarmerFactory;
use App\Tests\Factory\Security\AccessTokenFactory;
use Brick\Money\Money;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FarmTransactionGetCollectionTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_collection_farm_transactions(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $user2 = FarmerFactory::createOne(['username' => 'user_login_2']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);
        $farm2 = FarmFactory::createOne(['relatedFarmer' => $user2, 'name' => 'FARM-2']);

        $transaction1 = FarmTransactionFactory::createOne([
            'amount' => Money::of(100_000, MooCurrencyFactory::create()),
            'creationDatetime' => \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2001-01-01T07:00:00+00:00'),
            'currencyCode' => 'MOO',
            'direction' => TransactionDirection::In,
            'externalId' => 'external_id_1',
            'relatedFarm' => $farm,
            'type' => TransactionType::Initial,
        ]);

        FarmTransactionFactory::createOne([
            'amount' => Money::of(100_000, MooCurrencyFactory::create()),
            'creationDatetime' => \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2001-01-01T07:00:00+00:00'),
            'currencyCode' => 'MOO',
            'direction' => TransactionDirection::In,
            'externalId' => 'external_id_2',
            'relatedFarm' => $farm2,
            'type' => TransactionType::Initial,
        ]);


        static::createClient()->request('GET', '/api/farm/FARM-1/transactions', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context"   => "/api/contexts/FarmTransaction",
            "@id"        => "/api/farm/FARM-1/transactions",
            "@type"      => "Collection",
            "member"     => [
                [
                "@id"                  => "/api/farm/transactions/external_id_1",
                "@type"                => "FarmTransaction",
                "amount"               => 100_000,
                "description"          => $transaction1->getDescription(),
                "direction"            => "IN",
                "id"                   => "external_id_1",
                "transaction_datetime" => "2001-01-01T07:00:00+00:00",
                "type"                 => "INITIAL",
            ],
            ],
            "totalItems" => 1,
        ]);
    }

    public function test_get_collection_farm_transactions_not_found(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        static::createClient()->request('GET', '/api/farm/FARM-NOT-FOUND/transactions', [
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

    public function test_get_collection_farm_transactions_without_login(): void
    {
        static::createClient()->request('GET', '/api/farm/no-login/transactions');
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