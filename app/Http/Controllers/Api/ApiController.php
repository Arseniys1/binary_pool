<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function success_response($response = []) {
        return json_encode([
            'success' => true,
            'response' => $response,
        ]);
    }

    protected function error_response($error = []) {
        return json_encode([
            'success' => false,
            'error' => $error,
        ]);
    }

}
