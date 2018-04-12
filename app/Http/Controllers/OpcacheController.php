<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Appstract\Opcache\OpcacheFacade as Opcache;

class OpcacheController extends Controller
{
    public function get(Request $request) {
        switch ($request->route('action')) {
            case 'clear':
                $result = Opcache::clear();
                return response('Opcache clear result ' . json_encode($result));
                break;
            case 'optimize':
                $result = Opcache::optimize();
                return response('Opcache optimize result ' . json_encode($result));
                break;
        }
    }
}
