<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SourcesListController extends Controller
{
    public function get(Request $request) {
        return view('sources_list');
    }
}
