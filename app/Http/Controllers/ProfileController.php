<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\NotifyAccess;

class ProfileController extends Controller
{
    public function get(Request $request) {
        $user = User::where('id', '=', $request->route('user_id'))->with('settings')->first();
        $fast_stat = null;
        $notify_access = null;

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
        }

        return view('profile')->with([
            'user' => $user,
            'fast_stat' => $fast_stat,
            'notify_access' => $notify_access,
            'title' => 'Профиль' . $user->name,
        ]);
    }
}
