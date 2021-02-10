<?php

namespace App\Http\Controllers;

use App\Facades\Rates;
use App\Facades\Validate;

class LatestController extends Controller
{
    public function index()
    {
        $base = request()->get('base') ?? 'EUR';

        $validate = Validate::currency($base, 'base');

        if ($validate->getErrors()) {
            return response($validate->getErrors(), 400);
        }

        $rates = Rates::currency($base)->get();

        return response($rates, 200);
    }
}
