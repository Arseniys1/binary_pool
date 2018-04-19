<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Request as RequestFacade;
use App\User;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function __construct()
    {
        if (RequestFacade::has('api_token')) {
            $user = User::where('api_token', '=', RequestFacade::input('api_token'))->first();

            if ($user != null) {
                Auth::login($user);

                // Авторизация пользователя для api, если это не сделать будет Auth::user() null

                $this->updateLastOnline();
            }
        }
    }

    private function updateLastOnline() {
        Auth::user()->last_online = Carbon::now()->format('Y-m-d H:i:s');
        Auth::user()->save();
    }

    protected function success_response($response = []) {
        return response()
            ->json([
                'success' => true,
                'response' => $response,
            ]);
    }

    protected function error_response($error = []) {
        return response()
            ->json([
                'success' => false,
                'error' => $error,
            ]);
    }

}
