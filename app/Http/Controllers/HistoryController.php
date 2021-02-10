<?php

namespace App\Http\Controllers;

use App\Facades\Rates;

class HistoryController extends Controller
{
    public function index()
    {
        if (! \request()->has('start_at') || ! \request()->has('end_at')) {
            abort(404);
        }

        $from = \request()->get('start_at');
        $to = \request()->get('end_at');
        $base = request()->get('base') ?? 'EUR';

        $rates = Rates::currency($base)->between($from, $to)->get();

        return response($rates, 200);

    }

    public function show($date)
    {
        $base = request()->get('base') ?? 'EUR';
        $rates = Rates::currency($base)->date($date)->get();

        return response($rates, 200);
    }
}
