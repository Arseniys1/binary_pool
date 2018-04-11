<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SubscribeController extends Controller
{
    public function get(Request $request) {
        $user = User::where('id', '=', $request->route('user_id'))
            ->with('settings')
            ->first();

        if ($user == null) {
            return view('subscribe')->withErrors([
                'Пользователь не найден',
            ]);
        }

        foreach ($user->settings as $setting) {
            if ($setting->name == 'price' && $setting->value == null) {
                return view('subscribe')->withErrors([
                    'У пользователя отключена покупка оповещений',
                ]);
            }
        }

        return view('subscribe')->with([
            'user' => $user,
        ]);
    }

    public function subscribeGo(Request $request) {
        $user = User::where('id', '=', $request->route('user_id'))
            ->with('settings')
            ->first();

        if ($user == null) {
            return view('subscribe')->withErrors([
                'Пользователь не найден',
            ]);
        }

        foreach ($user->settings as $setting) {
            if ($setting->name == 'price' && $setting->value == null) {
                return view('subscribe')->withErrors([
                    'У пользователя отключена покупка оповещений',
                ]);
            }
        }

        return response('Redirecting to payment system');
    }
}
