<?php

namespace App\Enum\Transaction;
enum TransactionType: int
{
    case Initial = 0;
    case Seed = 1;
    case BuildingUpgrade = 2;
    case Extension = 3;

    public function type(): string
    {
        return match ($this) {
            self::Initial => 'INITIAL',
            self::Seed => 'SEED',
            self::BuildingUpgrade => 'BUILDING_UPGRADE',
            self::Extension => 'EXTENSION',
        };
    }
}