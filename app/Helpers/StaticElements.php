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
            'sources' => Auth::user()->sources()->limit(15)->get(),
            'listeners' => Auth::user()->listeners()->limit(15)->get(),
        ]);
    }

    public function makeUnAuthData()
    {
        JavaScript::put([
            'auth' => false,
            'sources' => [],
            'listeners' => [],
        ]);
    }


}