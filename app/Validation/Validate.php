<?php

namespace App\Validation;

class Validate
{
    private $errors = [];
    private $currencies = ['EUR', 'CAD', 'HKD', 'ISK', 'PHP', 'DKK', 'HUF', 'CZK', 'AUD', 'RON'
    , 'SEK', 'IDR', 'INR', 'BRL', 'RUB', 'HRK', 'JPY', 'THB', 'CHF', 'SGD', 'PLN'
    , 'BGN', 'TRY', 'CNY', 'NOK', 'NZD', 'ZAR', 'USD', 'MXN', 'ILS', 'GBP', 'KRW', 'MYR'
    ];
    public function currency($currency, $name = 'currency')
    {
        if (! in_array($currency, $this->currencies)) {
            $this->errors['errors'][$name] = "Requested {$name} {$currency} is invalid.'";
        }

        return $this;
    }

    public function date($date, $name = 'date')
    {
        if(! preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $date)) {
            $this->errors['errors'][$name] = "The {$name} must be YYYY-MM-DD format";
            return $this;
        }

        $date = explode('-', $date);
        if (! checkdate($date[1], $date[2], $date[0])) {
            $this->errors['errors'][$name] = "The {$name} must be existing date";
        }

        return $this;
    }

    public function symbols($symbols)
    {
        if (is_null($symbols)) {
            return $this;
        }

        $symbols =  explode(',', $symbols);
        foreach ($symbols as $symbol) {
            if (!in_array($symbol, $this->currencies)) {
                $this->errors['errors'][$symbol] = "Symbol is invalid.";
            }
        }

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }


}
