<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format a number as Philippine Peso
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    public static function formatPeso($amount, $decimals = 2)
    {
        return '₱' . number_format($amount, $decimals);
    }
}
