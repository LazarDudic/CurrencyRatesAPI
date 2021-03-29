<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class Converter
{
    protected $rates = [];
    protected $symbols;

    public function __construct($currencies, $name, $symbols)
    {
        $this->symbols = $symbols;

        if ($currencies instanceof Collection) {
            $this->convertBetweenDaysRates($name, $currencies);
        } else {
            $this->convertRates($name, $currencies);
        }
    }

    private function convertRates(string $currencyName, $currencies)
    {
        $this->rates['base'] = $currencyName;
        $this->rates['date'] = $currencies->created_at;

        $rates = json_decode($currencies->rates);

        // EUR is default.
        if ($currencyName === 'EUR') {
            foreach ($rates as $currency => $rate) {
                if (in_array($currency, $this->symbols)) {
                    $this->rates['rates'][$currency] =  $rate;
                }
            }
            return;
        }

        // All other currencies we get converting from EUR = 1
        $requestedCurrency = Currency::where('name', $currencyName)->latest()->first();
        if (in_array('EUR', $this->symbols)) {
            $this->rates['rates']['EUR'] = number_format(1 / $requestedCurrency->rate, 4);
        }

        foreach ($rates as $currency => $rate) {
            if (in_array($currency, $this->symbols) && $currencyName !== $currency) {
                $this->rates['rates'][$currency] = number_format(1 / $requestedCurrency->rate * $rate, 4);
            }
        }

    }

    private function convertBetweenDaysRates($currencyName, $dates)
    {
        // EUR is default.
        if ($currencyName === 'EUR') {
            foreach ($dates as $date) {
                $this->rates[$date->created_at]['base'] = $currencyName;
                $rates = json_decode($date->rates);
                foreach ($rates as $currency => $rate) {
                    if (in_array($currency, $this->symbols)) {
                        $this->rates[$date->created_at]['rates'][$currency] = $rate;
                    }
                }
            }
            return;
        }

        // All other currencies we get converting from EUR = 1
        foreach ($dates as $date) {
            $rates = json_decode($date->rates);
            $requestedCurrencyRate = $rates->$currencyName;

            $this->rates[$date->created_at]['base'] = $currencyName;

            if (in_array('EUR', $this->symbols)) {
                $this->rates[$date->created_at]['rates']['EUR'] = number_format(1 / $requestedCurrencyRate, 4);
            }

            foreach ($rates as $currency => $rate) {
                if (in_array($currency, $this->symbols) && $currencyName !== $currency) {
                    $this->rates[$date->created_at]['rates'][$currency] = number_format(1 / $requestedCurrencyRate * $rate, 4);
                }
            }
        }

    }

    public function getRates()
    {
        return $this->rates;
    }
}
