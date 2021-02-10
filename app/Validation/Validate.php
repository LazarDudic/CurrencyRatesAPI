<?php

namespace App\Validation;

class Validate
{
    public static function currency($currency)
    {
        $currencies = ['EUR', 'CAD', 'HKD', 'ISK', 'PHP', 'DKK', 'HUF', 'CZK', 'AUD', 'RON'
            , 'SEK', 'IDR', 'INR', 'BRL', 'RUB', 'HRK', 'JPY', 'THB', 'CHF', 'SGD', 'PLN'
            , 'BGN', 'TRY', 'CNY', 'NOK', 'NZD', 'ZAR', 'USD', 'MXN', 'ILS', 'GBP', 'KRW', 'MYR'
        ];

        return in_array($currency, $currencies);
    }

    public static function date($date)
    {
        if(! preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $date)) {
            return false;
        };
        $date = explode('-', $date);

        return checkdate($date[1], $date[2], $date[0]);
    }
}
