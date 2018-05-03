<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class StaticElementsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'StaticElements';
    }

}