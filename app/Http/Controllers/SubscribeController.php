<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Payment;
use Auth;

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
        } else if (Auth::user()->id == $request->route('user_id')) {
            return view('subscribe')->withErrors([
                'Вы не можете подписаться на себя',
            ]);
        }

        foreach ($user->settings as $setting) {
            if ($setting->name == 'price' && $setting->value == null) {
                return view('subscribe')->withErrors([
                    'У пользователя отключена покупка оповещений',
                ]);
            }
        }

        $payment = new Payment;
        $payment->user_id = Auth::user()->id;
        $payment->source_id = $request->route('user_id');

        foreach ($user->settings as $setting) {
            if ($setting->name == 'price') {
                $payment->price = $setting->value;
            } else if ($setting->name == 'days') {
                $payment->days = $setting->value;
            } else if ($setting->name == 'forever') {
                $payment->forever = $setting->value;
            }
        }

        $payment->save();

        return view('subscribe')->with([
            'user' => $user,
            'payment' => $payment,
        ]);
    }
}
