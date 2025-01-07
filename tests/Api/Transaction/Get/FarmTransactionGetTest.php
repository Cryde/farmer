<?php

namespace Api\Transaction\Get;

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

class FarmTransactionGetTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function test_get_item_farm_transactions(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'FARM-1']);

        $transaction1 = FarmTransactionFactory::createOne([
            'amount' => Money::of(100_000, MooCurrencyFactory::create()),
            'creationDatetime' => \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2001-01-01T07:00:00+00:00'),
            'currencyCode' => 'MOO',
            'direction' => TransactionDirection::In,
            'externalId' => 'external_id_1',
            'relatedFarm' => $farm,
            'type' => TransactionType::Initial,
        ]);

        static::createClient()->request('GET', '/api/farm/transactions/external_id_1', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            "@context" => "/api/contexts/FarmTransaction",
            "@id"                  => "/api/farm/transactions/external_id_1",
            "@type"                => "FarmTransaction",
            "amount"               => 100_000,
            "description"          => $transaction1->getDescription(),
            "direction"            => "IN",
            "id"                   => "external_id_1",
            "transaction_datetime" => "2001-01-01T07:00:00+00:00",
            "type"                 => "INITIAL",
        ]);
    }

    public function test_get_item_farm_transactions_not_found(): void
    {
        $user = FarmerFactory::createOne(['username' => 'user_login']);
        $token = AccessTokenFactory::createOne(['relatedFarmer' => $user]);

        static::createClient()->request('GET', '/api/farm/transactions/NOT-FOUND', [
            'auth_bearer' => $token->getToken(),
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertJsonEquals([
            "@context"    => "/api/contexts/Error",
            "@id"         => "/api/errors/404",
            "@type"       => "Error",
            "description" => "Transaction not found",
            "detail"      => "Transaction not found",
            "status"      => 404,
            "title"       => "An error occurred",
            "type"        => "/errors/404",
        ]);
    }

    public function test_get_item_farm_transactions_without_login(): void
    {
        static::createClient()->request('GET', '/api/farm/transactions/no-login');
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