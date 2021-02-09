<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Rates extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rates';
    }
}
