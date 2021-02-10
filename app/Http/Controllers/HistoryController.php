<?php

namespace App\Http\Controllers;

use App\Facades\Rates;
use App\Facades\Validate;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if (! isset($request->start_at) || ! isset($request->end_at)) {
            return response(['error' => 'The start_at and end_at is required.'], 400);
        }

        $base = $request->base ?? 'EUR';

        $validate = Validate::currency($base, 'base')
            ->date($request->start_at, 'start_at')
            ->date($request->end_at, 'end_at')
            ->symbols($request->symbols);

        if ($validate->getErrors()) {
            return response($validate->getErrors(), 400);
        }

        $rates = Rates::currency($base)
            ->between($request->start_at, $request->end_at)
            ->symbols($request->symbols)
            ->get();

        if (is_null($rates)) {
            return response(['error' => 'Data between requested dates not found.'], 404);
        }

        return response($rates, 200);
    }

    public function show($date, Request $request)
    {
        $base = $request->base ?? 'EUR';

        $validate = Validate::currency($base, 'base');

        if ($validate->getErrors()) {
            return response($validate->getErrors(), 400);
        }

        $rates = Rates::currency($base)->date($date)->get();

        if (is_null($rates)) {
            return response(['error' => 'Data for '.$date.' not found.'], 404);
        }

        return response($rates, 200);
    }
}
