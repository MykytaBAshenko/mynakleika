<?php

namespace App\Helpers\General;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * Class MoneyHelper
 * @package App\Helpers\General
 */
class MoneyHelper
{
    /**
     * @param int $value
     * @return string
     */
    public static function toString(int $value): string
    {
        $money = new Money($value, new Currency('UAH'));
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function parseToInt(string $value): int
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        $amount = $moneyParser->parse($value, new Currency('UAH'))->getAmount();

        return (int) $amount;
    }
}
