<?php

namespace App\Http\Controllers;

use App\Facades\Rates;
use App\Validation\Validate;

class LatestController extends Controller
{
    public function index()
    {
        $base = request()->get('base') ?? 'EUR';

        $rates = Rates::currency($base)->get();

        return response($rates, 200);
    }
}
