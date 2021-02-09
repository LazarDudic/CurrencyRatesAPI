<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\History;
use App\Validation\Validate;
use Carbon\Carbon;

class Rates
{
    public function get($currency = 'EUR')
    {
        if (! Validate::currency($currency)) {
            abort(404);
        }

        $history = History::latest()->first();
        $currencies  = json_decode($history->rates);
        $convert = new Converter($currencies);
        $rates = $convert->getRates();
        $rates['date'] = $history->created_at;

        return $rates;
    }

}
