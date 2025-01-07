<?php

namespace App\Enum\Transaction;
enum TransactionDirection: int
{
    case In = 0;
    case Out = 1;

    public function type(): string
    {
        return match ($this) {
            self::In => 'IN',
            self::Out => 'OUT',
        };
    }
}