<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifyAccess;
use Auth;

class MyAccessController extends Controller
{
    public function get(Request $request) {
        $notify_access = NotifyAccess::where('user_id', '=', Auth::user()->id)
            ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
            ->with('source')
            ->get();

        $source_id = Auth::user()->settings()
            ->where('name', '=', 'notify_id')
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        $notify_access_result = [];

        foreach ($notify_access as $notify) {
            if ($notify->access_type == NotifyAccess::LIMITED_ACCESS && strtotime($notify->end_at) <= time()) {
                $notify->status = NotifyAccess::EXPIRED_STATUS;
                $notify->save();

                if ($source_id->value == $notify->source_id) {
                    $source_id->value = null;
                    $source_id->save();
                }

                continue;
            }

            $notify_access_result[] = $notify;
        }

        return view('my_access')->with([
            'notify_access' => $notify_access_result,
        ]);
    }
}
