<?php

namespace App\Helpers;

use App\Helpers\Contracts\StaticElements as StaticElementsContract;
use JavaScript;
use Auth;

class StaticElements implements StaticElementsContract
{
    public function makeData()
    {
        if (Auth::check()) {
            $this->makeAuthData();
        } else {
            $this->makeUnAuthData();
        }
    }

    public function makeAuthData()
    {
        JavaScript::put([
            'auth' => true,
            'user' => Auth::user()->load('settings'),
        ]);
    }

    public function makeUnAuthData()
    {
        JavaScript::put([
            'auth' => false,
        ]);
    }


}