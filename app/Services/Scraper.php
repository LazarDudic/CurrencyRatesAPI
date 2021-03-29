<?php

namespace App\Services;

class Scraper
{
    private $currencies = [];
    private $availableCurrencies = ['CAD', 'HKD', 'ISK', 'PHP', 'DKK', 'HUF', 'CZK', 'AUD', 'RON'
    , 'SEK', 'IDR', 'INR', 'BRL', 'RUB', 'HRK', 'JPY', 'THB', 'CHF', 'SGD', 'PLN'
    , 'BGN', 'TRY', 'CNY', 'NOK', 'NZD', 'ZAR', 'USD', 'MXN', 'ILS', 'GBP', 'KRW', 'MYR'
    ];
    public function __construct()
    {
        $curl = curl_init();
        $c = 0;
        foreach ($this->availableCurrencies as $currency) {
            $url = 'https://www.x-rates.com/calculator/?from=EUR&to='.$currency.'&amount=1';
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $data = curl_exec($curl);

            preg_match('/<span class="ccOutputRslt">([0-9.?,?]*)<span class="ccOutputTrail">/', $data, $matches);

            $match = str_replace(',', '', $matches[1]);
            $this->currencies[$c]['rate'] = $match;
            $this->currencies[$c]['name'] = $currency;
            $c++;
        }
    }


    public function getCurrency()
    {
        return $this->currencies;
    }

}
