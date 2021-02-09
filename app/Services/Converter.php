<?php

namespace App\Services;

use App\Models\Currency;
use App\Validation\Validate;

class Converter
{
    protected $rates = [];

    public function __construct($currencies, $name = 'EUR')
    {
        if (! Validate::currency($name)) {
            throw new \Exception('Currency not found.');
        }

        $this->rates['base'] = $name;

        if ($name !== 'EUR') {
            $this->convertRates($name, $currencies);
        } else {
            foreach ($currencies as $name => $rate) {
                $this->rates['rates'][$name] =  $rate;
            }
        }
    }

    /**
     * @param string $name
     * @param $currencies
     */
    private function convertRates(string $name, $currencies): void
    {
        $requestedCurrency = Currency::where('name', $name)->latest()->first();
        $this->rates['rates']['EUR'] = number_format(1 / $requestedCurrency->rate, 4);

        foreach ($currencies as $name => $rate) {
            $this->rates['rates'][$name] = number_format(1 / $requestedCurrency->rate * $rate, 4);
        }
    }

    public function getRates()
    {
        return $this->rates;
    }
}
