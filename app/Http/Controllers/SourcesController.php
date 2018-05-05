<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class SourcesController extends Controller
{
    public function get(Request $request) {
        return view('pages.sources');
    }
}
