<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFastStat;
use App\User;

class SourcesListController extends Controller
{
    public function get(Request $request) {
        $fast_stat = null;

        if ($request->route('search_mode') == 'source' || $request->route('search_mode') == null) {
            $fast_stat = $this->getBestFastStatSources(User::SOURCE_MODE);
        } else if ($request->route('search_mode') == 'source_demo') {
            $fast_stat = $this->getBestFastStatSources(User::DEMO_SOURCE);
        }

        return view('sources_list')->with([
            'fast_stat' => $fast_stat,
            'title' => 'Статистика источников',
        ]);
    }

    private function getBestFastStatSources($account_mode) {
        $best_fast_stat = UserFastStat::where('account_mode', '=', $account_mode)
            ->orderBy('success_count', 'desc')
            ->orderBy('win_sum', 'desc')
            ->with('user', 'user.settings')
            ->paginate(20);

        return $best_fast_stat;
    }
}
