<?php

namespace App\Tests\Factory\Farm;

use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmTransaction;
use App\Enum\Transaction\TransactionDirection;
use App\Enum\Transaction\TransactionType;
use App\Factory\Transaction\MooCurrencyFactory;
use Brick\Money\Money;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<FarmTransaction>
 */
final class FarmTransactionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return FarmTransaction::class;
    }

    protected function defaults(): array
    {
        return [
            'amount' => self::faker()->randomNumber(),
            'creationDatetime' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'currencyCode' => 'MOO',
            'description' => self::faker()->text(),
            'direction' => self::faker()->randomElement(TransactionDirection::cases()),
            'externalId' => self::faker()->text(50),
            'relatedFarm' => null, // TODO add App\Entity\Farm\Farm type manually
            'type' => self::faker()->randomElement(TransactionType::cases()),
        ];
    }

    public function asInitialTransaction(Farm $farm): self
    {
        return $this->with([
            'amount' => Money::of(100_000, MooCurrencyFactory::create()),
            'creationDatetime' => \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2001-01-01T07:00:00+00:00'),
            'currencyCode' => 'MOO',
            'direction' => TransactionDirection::In,
            'externalId' => 'external_id_1',
            'relatedFarm' => $farm,
            'type' => TransactionType::Initial,
        ]);
    }

    public function asOutTransaction(Farm $farm, int $amount, TransactionType $transactionType): self
    {
        return $this->with([
            'amount' => Money::of($amount, MooCurrencyFactory::create()),
            'creationDatetime' => \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2001-01-01T07:00:00+00:00'),
            'currencyCode' => 'MOO',
            'direction' => TransactionDirection::Out,
            'externalId' => 'external_id_' . random_int(0, 1000),
            'relatedFarm' => $farm,
            'type' => $transactionType,
        ]);
    }

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FarmTransaction $farmTransaction): void {})
        ;
    }
}
