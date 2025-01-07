<?php

namespace App\Tests\Factory\Farm;

use App\Entity\Farm\FarmTransaction;
use App\Enum\Transaction\TransactionDirection;
use App\Enum\Transaction\TransactionType;
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

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FarmTransaction $farmTransaction): void {})
        ;
    }
}
