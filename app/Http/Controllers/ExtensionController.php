<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ExtensionController extends Controller
{
    public function get(Request $request) {
        return view('extension');
    }

    public function post(Request $request) {
        Auth::user()->api_token = str_random(32);
        Auth::user()->save();

        return redirect()->route('ext');
    }

    public function extNotInstalled(Request $request) {
        return response(1);
    }
}
