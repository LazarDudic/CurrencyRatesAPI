<?php

namespace App\Services;

use App\Models\History;
use App\Validation\Validate;
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
    public function currency($currency)
    {
        if (! Validate::currency($currency)) {
            abort(404);
        }

        $this->currency = $currency;
        return $this;
    }

    public function date($date)
    {
        if (! Validate::date($date)) {
            abort(404);
        }

        $this->date = Carbon::parse($date);
        return $this;
    }

    public function between($from, $to)
    {
        if (! Validate::date($from) || ! Validate::date($to)) {
            abort(404);
        }

        $this->between['from'] = Carbon::parse($from);
        $this->between['to'] = Carbon::parse($to);
        return $this;
    }

    public function get()
    {
        if (count($this->between) === 2) {
            $history = History::whereBetween('created_at', [
                $this->between['from'],
                $this->between['to']
            ])->get();

        } else {
            $history = History::whereDate('created_at', $this->date)->latest()->firstOrFail();
        }

        $convert = new Converter($history, $this->currency);
        $this->rates = $convert->getRates();

        return $this->rates;
    }


}
