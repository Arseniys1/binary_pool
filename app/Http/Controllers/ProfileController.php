<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\NotifyAccess;
use App\Models\UserStat;
use Auth;
use Validator;
use App\Models\UserSetting;
use App\Models\Balance;

class ProfileController extends Controller
{
    public function get(Request $request) {
        $user = User::where('id', '=', $request->route('user_id'))->with('settings')->first();
        $fast_stat = null;
        $notify_access = null;
        $user_stat = null;
        $user_settings = null;
        $balance = null;

        if ($user == null) {
            return view('profile')->with([
                'title' => '',
            ])->withErrors(['Профиль не найден']);
        } elseif ($request->route('mode') == 'fast_stat' || $request->route('mode') == null) {
            $fast_stat = $user->fastStat()->paginate(20);
        } elseif ($request->route('mode') == 'listeners') {
            $notify_access = NotifyAccess::where('source_id', '=', $user->id)
                ->where('is_hidden', '=', NotifyAccess::HIDDEN_DISABLE)
                ->with('user', 'user.fastStat')
                ->paginate(20);
        } elseif ($request->route('mode') == 'my_stat' && Auth::user()->id == $request->route('user_id')) {
            $user_stat = UserStat::where('user_id', '=', Auth::user()->id)
                ->with('source', 'source.sourceStat')
                ->paginate(20);
        } elseif ($request->route('mode') == 'my_settings' && Auth::user()->id == $request->route('user_id')) {
            $user_settings = Auth::user()->settings;
            $notify_access = Auth::user()->notifyAccess;
        } elseif ($request->route('mode') == 'my_balance' && Auth::user()->id == $request->route('user_id')) {
            $user_settings = Auth::user()->settings()
                ->where('name', '=', 'balance')
                ->first();

            $balance = Balance::where('user_id', '=', Auth::user()->id)
                ->limit(20)
                ->get();
        }

        return view('profile')->with([
            'user' => $user,
            'fast_stat' => $fast_stat,
            'notify_access' => $notify_access,
            'user_stat' => $user_stat,
            'user_settings' => $user_settings,
            'balance' => $balance,
            'title' => 'Профиль' . $user->name,
        ]);
    }

    public function post(Request $request) {
        if ($request->route('mode') == 'subscribe') {
            $v = Validator::make($request->all(), [
                'price' => 'required_with:enable_price|integer|min:100',
                'days' => 'required_without:enable_forever|integer|min:1',
            ]);

            if ($v->fails()) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_settings',
                ])->withErrors($v->errors());
            }

            if ($request->input('enable_price')) {
                $price = UserSetting::where('name', '=', 'price')
                    ->where('user_id', '=', Auth::user()->id)
                    ->first();
                $price->value = $request->input('price') * 100;
                $price->save();

                if ($request->input('enable_forever')) {
                    $forever = UserSetting::where('name', '=', 'forever')
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
                    $forever->value = true;
                    $forever->save();
                } else {
                    $forever = UserSetting::where('name', '=', 'forever')
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
                    $forever->value = false;
                    $forever->save();

                    $days = UserSetting::where('name', '=', 'days')
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
                    $days->value = $request->input('days');
                    $days->save();
                }
            } else {
                $price = UserSetting::where('name', '=', 'price')
                    ->where('user_id', '=', Auth::user()->id)
                    ->first();
                $price->value = null;
                $price->save();
            }

            return redirect()->route('profile', [
                'user_id' => Auth::user()->id,
                'mode' => 'my_settings',
            ]);
        } elseif ($request->route('mode') == 'notify_id') {
            $v = Validator::make($request->all(), [
                'notify_id' => 'required|integer',
            ]);

            if ($v->fails()) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_settings',
                ])->withErrors($v->errors());
            }

            $notify_access = NotifyAccess::where('source_id', '=', $request->input('notify_id'))
                ->where('user_id', '=', Auth::user()->id)
                ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
                ->first();

            if ($notify_access == null) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_settings',
                ])->withErrors(['Подписка не найдена или истекла']);
            }

            $notify_id = UserSetting::where('user_id', '=', Auth::user()->id)
                ->where('name', '=', 'notify_id')
                ->first();
            $notify_id->value = $notify_access->source_id;
            $notify_id->save();

            return redirect()->route('profile', [
                'user_id' => Auth::user()->id,
                'mode' => 'my_settings',
            ]);
        } elseif ($request->route('mode') == 'balance') {
            $v = Validator::make($request->all(), [
                'comment' => 'required|string',
            ]);

            if ($v->fails()) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_balance',
                ])->withErrors($v->errors());
            }

            $balance = Balance::where('user_id', '=', Auth::user()->id)
                ->where('status', '=', Balance::NOT_PROCESSED_STATUS)
                ->first();

            $balance_settings = UserSetting::where('user_id', '=', Auth::user()->id)
                ->where('name', '=', 'balance')
                ->first();

            if ($balance != null) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_balance',
                ])->withErrors(['У вас есть созданная заявка']);
            } elseif ($balance_settings->value == 0) {
                return redirect()->route('profile', [
                    'user_id' => Auth::user()->id,
                    'mode' => 'my_balance',
                ])->withErrors(['Ваш баланс 0']);
            }

            $balance = new Balance;
            $balance->user_id = Auth::user()->id;
            $balance->status = Balance::NOT_PROCESSED_STATUS;
            $balance->comment = $request->input('comment');
            $balance->save();

            return redirect()->route('profile', [
                'user_id' => Auth::user()->id,
                'mode' => 'my_balance',
            ]);
        }
    }

}
