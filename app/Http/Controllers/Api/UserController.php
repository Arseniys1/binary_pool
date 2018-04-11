<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use App\Models\NotifyAccess;

class UserController extends ApiController
{
    public function getUser(Request $request) {
        return $this->success_response(Auth::user()->load('settings'));
    }

    public function changeAccountMode() {
        $account_mode = Auth::user()
            ->settings()
            ->where('name', '=', 'account_mode')
            ->first();
        $account_mode->value = !$account_mode->value;
        $account_mode->save();

        return $this->success_response(Auth::user()->load('settings'));
    }

    public function changeSource(Request $request) {
        if ($request->route('source_id') != null) {
            $notify_access = Auth::user()->notifyAccess()->where('source_id', '=', $request->route('source_id'))
                ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
                ->first();

            if ($notify_access == null) {
                return $this->error_response('source_id not found or expired status');
            } elseif ($notify_access->access_type == NotifyAccess::LIMITED_ACCESS && strtotime($notify_access->end_at) <= time()) {
                $this->expiredNotify($notify_access);

                return $this->error_response('notification access expired');
            }

            $setting_notify_id = Auth::user()->settings()->where('name', '=', 'notify_id')->first();
            $setting_notify_id->value = $notify_access->source_id;
            $setting_notify_id->save();
        } else {
            $setting_notify_id = Auth::user()->settings()->where('name', '=', 'notify_id')->first();
            $setting_notify_id->value = null;
            $setting_notify_id->save();
        }

        return $this->success_response(Auth::user()->load('settings'));
    }

    public function demo(Request $request) {
        $demo = Auth::user()->settings()->where('name', '=', 'demo')->first();
        $demo->value = !$demo->value;
        $demo->save();

        return $this->success_response(Auth::user()->load('settings'));
    }

    public function access(Request $request) {
        return $this->success_response(Auth::user()
            ->notifyAccess()
            ->with('source')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get());
    }

    private function expiredNotify($notify_access) {
        $notify_access->status = NotifyAccess::EXPIRED_STATUS;
        $notify_access->save();
    }
}
