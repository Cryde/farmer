<?php

namespace App\Factory\Transaction;

use Brick\Money\Currency;

class MooCurrencyFactory
{
    public static function create(): Currency
    {
        return new Currency(
            'MOO',
            0,
            'Mooney',
            2
        );
    }


}