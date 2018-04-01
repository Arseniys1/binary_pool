<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\NotifyAccess;
use App\User;
use App\Models\UserStat;
use App\Models\UserSetting;
use App\Models\SourceStat;
use Validator;

class NotifyController extends ApiController
{
    public function getNotify(Request $request) {
        $notify_expired = $this->notifyExpired();

        if (!$notify_expired[0]) {
            return $this->error_response($notify_expired[1]);
        } elseif (!$this->modeSource()) {
            return $this->error_response('mode source');
        }

        $show_stats = Auth::user()->showStats;

        $show_stats_result = [
            'create' => [],
            'update' => [],
        ];

        foreach ($show_stats as $stat) {
            DB::table('show_statistics')
                ->where('id', '=', $stat->pivot->id)
                ->delete();

            if ($stat->pivot->status == UserStat::CREATE_SHOW_STATUS && strtotime($stat->created_at) > time() - 10) {
                $show_stats_result['create'][] = $stat;
            } elseif ($stat->pivot->status == UserStat::UPDATE_SHOW_STATUS && strtotime($stat->updated_at) > time() - 10) {
                $show_stats_result['update'][] = $stat;
            }
        }

        return $this->success_response($show_stats_result);
    }

    public function sendNotify(Request $request) {
        $v = Validator::make($request->all(), [
            'platform_id' => 'required|integer',
            'direction' => 'required|boolean',
            'sum' => 'required|integer',
            'cur_pair' => 'required|string',
            'cur' => 'required|string',
            'demo' => 'boolean',
            'source_id' => 'integer',
        ]);

        if ($v->fails()) {
            return $this->error_response($v->errors());
        }

        $account_mode = Auth::user()->settings()->where('name', '=', 'account_mode')->first()->value;

        $stat = new UserStat;

        $stat->user_id = Auth::user()->id;
        $stat->platform_id = $request->input('platform_id');
        $stat->direction = $request->input('direction');
        $stat->sum = $request->input('sum') * 100;
        $stat->status = UserStat::NO_STATUS;
        $stat->cur_pair = $request->input('cur_pair');
        $stat->cur = $request->input('cur');

        if ($request->has('demo')) {
            $stat->demo = $request->input('demo');
        }

        if ($account_mode == User::SOURCE_MODE) {
            $stat->account_mode = User::SOURCE_MODE;
            $stat->save();

            $source_stat = new SourceStat;

            $source_stat->source_id = $stat->id;
            $source_stat->save();

            $show_statistics = $this->getSourceListenersToInsert($stat->id, UserStat::CREATE_SHOW_STATUS);

            DB::table('show_statistics')->insert($show_statistics);
        } elseif ($account_mode == User::LISTENER_MODE) {
            $stat->account_mode = User::LISTENER_MODE;

            if ($request->has('source_id')) {
                $source_stat = UserStat::where('id', '=', $request->input('source_id'))
                    ->first();

                if ($source_stat == null || $source_stat->account_mode != User::SOURCE_MODE) {
                    return $this->error_response('source_id not found or account_mode not SOURCE_MODE');
                }

                $notify_acceess = NotifyAccess::where('source_id', '=', $source_stat->user_id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
                    ->first();

                if ($notify_acceess == null) {
                    return $this->error_response('notify access not found');
                }

                $stat->is_hidden = $notify_acceess->is_hidden;
                $stat->source_id = $request->input('source_id');
            }

            $stat->save();
        }

        $stat = UserStat::find($stat->id);

        return $this->success_response($stat);
    }

    public function updateNotify(Request $request) {
        $v = Validator::make($request->all(), [
            'id' => 'required|integer',
            'status' => 'required|integer|in:0,1,2,3',
        ]);

        if ($v->fails()) {
            return $this->error_response($v->errors());
        }

        $stat = UserStat::where('id', '=', $request->input('id'))
            ->where('status', '=', UserStat::NO_STATUS)
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        if ($stat == null) {
            return $this->error_response('notify not found');
        }

        $stat->status = $request->input('status');
        $stat->save();

        if ($stat->is_hidden == UserStat::HIDDEN_DISABLE) {
            $this->updateUserFastStatistics($stat);
            $this->updateSourceStatistics($stat);
        }

        $show_statistics = $this->getSourceListenersToInsert($stat->id, UserStat::UPDATE_SHOW_STATUS);

        DB::table('show_statistics')->insert($show_statistics);

        return $this->success_response($stat);
    }

    public function getSourceStat(Request $request) {
        $v = Validator::make($request->all(), [
            'stat_ids' => 'required|array|min:1|max:10',
            'stat_ids.*' => 'integer',
        ]);

        if ($v->fails()) {
            return $this->error_response($v->errors());
        }

        $user_stats = UserStat::whereIn('id', $request->input('stat_ids'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('account_mode', '=', User::SOURCE_MODE)
            ->with('sourceStat')
            ->get();

        $source_stats = [];

        foreach ($user_stats as $user_stat) {
            $source_stats[] = $user_stat->sourceStat;
        }

        return $this->success_response($source_stats);
    }

    private function getSourceListenersToInsert($stat_id, $status) {
        $users_settings = UserSetting::where('name', '=', 'notify_id')
            ->where('value', '=', Auth::user()->id)
            ->get();

        $show_statistics = [];

        foreach ($users_settings as $setting) {
            $show_statistics[] = [
                'stat_id' => $stat_id,
                'user_id' => $setting->user_id,
                'status' => $status
            ];
        }

        return $show_statistics;
    }

    private function updateUserFastStatistics($stat) {
        $fast_stat = null;

        if ($stat->demo == User::DEMO_ENABLE && $stat->account_mode == User::SOURCE_MODE) {
            $fast_stat = Auth::user()->fastStat()->where('account_mode', '=', User::DEMO_SOURCE)->first();
        } elseif ($stat->demo == User::DEMO_ENABLE && $stat->account_mode == User::LISTENER_MODE) {
            $fast_stat = Auth::user()->fastStat()->where('account_mode', '=', User::DEMO_LISTENER)->first();
        } elseif ($stat->account_mode == User::SOURCE_MODE) {
            $fast_stat = Auth::user()->fastStat()->where('account_mode', '=', User::SOURCE_MODE)->first();
        } elseif ($stat->account_mode == User::LISTENER_MODE) {
            $fast_stat = Auth::user()->fastStat()->where('account_mode', '=', User::LISTENER_MODE)->first();
        }

        switch ($stat->status) {
            case UserStat::SUCCESS_STATUS:
                $fast_stat->success_count += 1;
                $fast_stat->win_sum += $stat->sum;
                break;
            case UserStat::LOSS_STATUS:
                $fast_stat->loss_status += 1;
                $fast_stat->loss_sum += $stat->sum;
                break;
            case UserStat::RET_STATUS:
                $fast_stat->ret_count += 1;
                break;
        }

        $fast_stat->save();
    }

    private function updateSourceStatistics($stat) {
        if ($stat->account_mode == User::LISTENER_MODE && $stat->source_id != null) {
            switch ($stat->status) {
                case UserStat::SUCCESS_STATUS:
                    $stat->source->sourceStat->success_count += 1;
                    $stat->source->sourceStat->win_sum += $stat->sum;
                    break;
                case UserStat::LOSS_STATUS:
                    $stat->source->sourceStat->loss_status += 1;
                    $stat->source->sourceStat->loss_sum += $stat->sum;
                    break;
                case UserStat::RET_STATUS:
                    $stat->source->sourceStat->ret_count += 1;
                    break;
            }

            $stat->source->sourceStat->save();
        }
    }

    private function notifyExpired()
    {
        $source_id = Auth::user()->settings()->where('name', '=', 'notify_id')->first()->value;

        if ($source_id == null) {
            return [
                false,
                'notify_id null',
            ];
        }

        $notify_access = Auth::user()->notifyAccess()
            ->where('source_id', '=', $source_id)
            ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
            ->first();

        if ($notify_access == null) {
            return [
                false,
                'no active notify access',
            ];
        } elseif ($notify_access->access_type == NotifyAccess::LIMITED_ACCESS && strtotime($notify_access->end_at) <= time()) {
            $notify_access->status = NotifyAccess::EXPIRED_STATUS;
            $notify_access->save();

            return [
                false,
                'notification access expired',
            ];
        }

        return [
            true,
        ];
    }

    private function modeSource() {
        $account_mode = Auth::user()->settings()->where('name', '=', 'account_mode')->first()->value;

        if ($account_mode == User::SOURCE_MODE) {
            return false;
        }

        return true;
    }
}
