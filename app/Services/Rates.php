<?php

namespace App\Services;

use App\Models\History;
use Carbon\Carbon;

class Rates
{
    private $currency = 'EUR';
    private $date;
    private $rates;
    private $between = [];

    public function __construct()
    {
        $this->date = Carbon::today();
    }

    public function get()
    {
        $history = $this->getHistory();

        if (is_null($history) || $history->count() === 0) {
            return null;
        }

        $convert = new Converter($history, $this->currency);
        $this->rates = $convert->getRates();

        return $this->rates;
    }

    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function date($date)
    {
        $this->date = Carbon::parse($date);
        return $this;
    }

    public function between($from, $to)
    {
        $this->between['from'] = Carbon::parse($from);
        $this->between['to'] = Carbon::parse($to);
        return $this;
    }

    private function getHistory()
    {
        if (count($this->between) === 2) {
            $history = History::whereBetween('created_at', [
                $this->between['from'],
                $this->between['to']
            ])->get();

        } else {
            $history = History::whereDate('created_at', $this->date)->latest()->first();
        }

        return $history;
    }


}
