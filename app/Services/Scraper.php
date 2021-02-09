<?php

namespace App\Services;

use App\Models\Currency;
use Carbon\Carbon;

class Scraper
{
    private $currencies = ['CAD', 'HKD', 'ISK', 'PHP', 'DKK', 'HUF', 'CZK', 'AUD', 'RON'
        , 'SEK', 'IDR', 'INR', 'BRL', 'RUB', 'HRK', 'JPY', 'THB', 'CHF', 'SGD', 'PLN'
        , 'BGN', 'TRY', 'CNY', 'NOK', 'NZD', 'ZAR', 'USD', 'MXN', 'ILS', 'GBP', 'KRW', 'MYR'
    ];

    private $rate;
    private $currencyName;

    public function __construct()
    {
        $count = Currency::whereDate('created_at', Carbon::today())->count();

        $data = file_get_contents('https://www.x-rates.com/calculator/?from=EUR&to='.$this->currencies[$count].'&amount=1');
        preg_match('/<span class="ccOutputRslt">([0-9.?,?]*)<span class="ccOutputTrail">/', $data, $matches);

        $match = str_replace(',', '', $matches[1]);
        $this->rate = $match;
        $this->currencyName = $this->currencies[$count];
    }

    public function getCurrencyRate()
    {
        return $this->rate;
    }

    public function getCurrencyName()
    {
        return $this->currencyName;
    }

}
