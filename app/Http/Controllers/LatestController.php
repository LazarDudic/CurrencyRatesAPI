<?php

namespace App\Http\Controllers;

use App\Facades\Rates;
use App\Facades\Validate;
use Illuminate\Http\Request;

class LatestController extends Controller
{
    public function index(Request $request)
    {
        $base = $request->base ?? 'EUR';

        $validate = Validate::currency($base, 'base')
            ->symbols($request->symbols);

        if ($validate->getErrors()) {
            return response($validate->getErrors(), 400);
        }

        $rates = Rates::currency($base)
            ->symbols($request->symbols)
            ->get();

        return response($rates, 200);
    }
}
