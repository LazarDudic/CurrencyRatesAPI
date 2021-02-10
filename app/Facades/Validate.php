<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Validate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'validate';
    }
}
