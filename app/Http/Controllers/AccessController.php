<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\AccessRequest;
use App\Models\NotifyAccessPreset;
use Validator;
use App\Models\NotifyAccess;
use Carbon\Carbon;
use App\Models\AccessLink;
use App\User;

class AccessController extends Controller
{
    public function get(Request $request) {
        return view('access.access')->with([
            'access_requests' => $this->getAccessRequests(),
        ]);
    }

    private function getAccessRequests() {
        return AccessRequest::join('notify_access_presets', function ($join) {
            $join->on('access_demo_requests.access_preset_id', '=', 'notify_access_presets.id')
                ->where('notify_access_presets.source_id', '=', Auth::user()->id)
                ->where('notify_access_presets.status', '=', NotifyAccessPreset::ACTIVE_STATUS)
                ->where('access_demo_requests.status', '=', AccessRequest::PROCESSING_STATUS);
        })
            ->select('access_demo_requests.*')
            ->paginate(20);
    }

    public function postRequestsAccept(Request $request) {
        $v = Validator::make($request->all(), [
            'request_id' => 'required|integer',
        ]);

        if ($v->fails()) {
            redirect()->back()->withErrors($v->errors());
        }

        $access_request = AccessRequest::find($request->input('request_id'));

        if ($access_request == null) {
            redirect()->back()->withErrors([
                'Запрос на доступ не найден',
            ]);
        } elseif($access_request->preset->source_id != Auth::user()->id) {
            redirect()->back()->withErrors([
                'Доступ не пренадлежит вам',
            ]);
        }

        $notify_access = new NotifyAccess;
        $notify_access->source_id = $access_request->preset->source_id;
        $notify_access->user_id = $access_request->user_id;
        $notify_access->status = NotifyAccess::ACTIVE_STATUS;

        if ($access_request->preset->forever) {
            $notify_access->access_type = NotifyAccess::PERMANENT_ACCESS;
        } else {
            $notify_access->access_type = NotifyAccess::LIMITED_ACCESS;
            $notify_access->end_at = Carbon::now()->addDays($access_request->preset->days);
        }

        $notify_access->save();

        $access_request->status = AccessRequest::ACCEPT_STATUS;
        $access_request->save();

        redirect()->back()->with([
            'success_message' => 'Запрос принят',
        ]);
    }

    public function postRequestsReject(Request $request) {
        $v = Validator::make($request->all(), [
            'request_id' => 'required|integer',
        ]);

        if ($v->fails()) {
            redirect()->back()->withErrors($v->errors());
        }

        $access_request = AccessRequest::find($request->input('request_id'));

        if ($access_request == null) {
            redirect()->back()->withErrors([
                'Запрос на доступ не найден',
            ]);
        } elseif($access_request->preset->source_id != Auth::user()->id) {
            redirect()->back()->withErrors([
                'Доступ не пренадлежит вам',
            ]);
        }

        $access_request->status = AccessRequest::REJECT_STATUS;
        $access_request->save();

        redirect()->back()->with([
            'success_message' => 'Запрос отклонен',
        ]);
    }

    public function getPresets(Request $request) {
        return view('access.presets')->with([
            'access_presets' => Auth::user()->notifyAccessPresets()->where('status', '=', NotifyAccessPreset::ACTIVE_STATUS)->get(),
        ]);
    }

    public function postPresetsSave(Request $request) {
        $v = Validator::make($request->all(), [
            'days' => 'required_without:forever|integer|min:1',
            'comment' => 'string|nullable',
        ]);

        if ($v->fails()) {
            return redirect()->route('access.presets')->with([
                'show_modal' => '#addAccessPreset',
                'save' => true,
            ])->withErrors($v->errors());
        }

        $notify_access_preset = new NotifyAccessPreset;
        $notify_access_preset->source_id = Auth::user()->id;
        $notify_access_preset->status = NotifyAccessPreset::ACTIVE_STATUS;

        if ($request->input('forever')) {
            $notify_access_preset->forever = 1;
        } else {
            $notify_access_preset->forever = 0;
            $notify_access_preset->days = $request->input('days');
        }

        if ($request->input('comment')) {
            $notify_access_preset->comment = $request->input('comment');
        }

        $notify_access_preset->save();

        return redirect()->route('access.presets')->with([
            'show_modal' => '#addAccessPreset',
            'success_message' => 'Успешно добавлено',
        ]);
    }

    public function postPresetsEdit(Request $request) {
        $v = Validator::make($request->all(), [
            'edit_access_id' => 'required|integer',
            'days' => 'required_without:forever|integer|min:1',
            'comment' => 'string|nullable',
        ]);

        if ($v->fails()) {
            return redirect()->route('access.presets')->with([
                'show_modal' => '#addAccessPreset',
                'edit' => true,
                'edit_id' => $request->input('edit_access_id'),
            ])->withErrors($v->errors());
        }

        $notify_access_preset = NotifyAccessPreset::find($request->input('edit_access_id'));

        if ($notify_access_preset == null) {
            return redirect()->route('access.presets')->with([
                'show_modal' => '#addAccessPreset',
                'edit' => true,
                'edit_id' => $request->input('edit_access_id'),
            ])->withErrors([
                'Доступ не найден'
            ]);
        } elseif ($notify_access_preset->source_id != Auth::user()->id) {
            return redirect()->route('access.presets')->with([
                'show_modal' => '#addAccessPreset',
                'edit' => true,
                'edit_id' => $request->input('edit_access_id'),
            ])->withErrors([
                'Вы не являетесь создателем доступа'
            ]);
        }

        if ($request->input('forever')) {
            $notify_access_preset->forever = 1;
        } else {
            $notify_access_preset->forever = 0;
            $notify_access_preset->days = $request->input('days');
        }

        $notify_access_preset->status = NotifyAccessPreset::ACTIVE_STATUS;

        if ($request->input('comment')) {
            $notify_access_preset->comment = $request->input('comment');
        }

        $notify_access_preset->save();

        return redirect()->route('access.presets')->with([
            'show_modal' => '#addAccessPreset',
            'success_message' => 'Успешно сохранено',
        ]);
    }

    public function postPresetsDelete(Request $request) {
        $v = Validator::make($request->all(), [
            'delete_id' => 'required|integer',
        ]);

        if ($v->fails()) {
            return redirect()->route('access.presets');
        }

        $notify_access_preset = NotifyAccessPreset::find($request->input('delete_id'));

        if ($notify_access_preset == null) {
            return redirect()->route('access.presets');
        } elseif ($notify_access_preset->source_id != Auth::user()->id) {
            return redirect()->route('access.presets');
        }

        $notify_access_preset->status = NotifyAccessPreset::REMOVE_STATUS;
        $notify_access_preset->save();

        return redirect()->route('access.presets');
    }

    public function getLinks(Request $request) {
        return view('access.links')->with([
            'access_links' => $this->getAccessLinks(),
            'access_presets' => $this->getAccessPresets(),
        ]);
    }

    private function getAccessLinks() {
        return AccessLink::join('notify_access_presets', function ($join) {
            $join->on('access_demo_links.access_preset_id', '=', 'notify_access_presets.id')
                ->where('notify_access_presets.source_id', '=', Auth::user()->id)
                ->where('notify_access_presets.status', '=', NotifyAccessPreset::ACTIVE_STATUS)
                ->where('access_demo_links.status', '=', AccessLink::NOT_USED_STATUS);
        })
            ->select('access_demo_links.*')
            ->paginate(20);
    }

    private function getAccessPresets() {
        return Auth::user()->notifyAccessPresets()
            ->where('source_id', '=', Auth::user()->id)
            ->where('status', '=', NotifyAccessPreset::ACTIVE_STATUS)
            ->get();
    }

    public function postLinksCreate(Request $request) {
        $v = Validator::make($request->all(), [
            'access_preset_id' => 'required|integer',
        ]);

        if ($v->fails()) {
            return redirect()->back()
                ->withErrors($v->errors());
        }

        $access_preset = NotifyAccessPreset::find($request->input('access_preset_id'));

        if ($access_preset == null) {
            return redirect()->back()
                ->withErrors([
                    'Доступ не найден',
                ]);
        } elseif ($access_preset->source_id != Auth::user()->id) {
            return redirect()->back()
                ->withErrors([
                    'Доступ не пренадлежит вам',
                ]);
        }

        $access_link = new AccessLink;
        $access_link->access_preset_id = $access_preset->id;
        $access_link->key = str_random(64);
        $access_link->status = AccessLink::NOT_USED_STATUS;
        $access_link->save();

        return redirect()->back()
            ->with([
                'success_message' => 'Ссылка создана',
            ]);
    }

    public function postLinksDelete(Request $request) {
        $v = Validator::make($request->all(), [
            'link_id' => 'required|integer',
        ]);

        if ($v->fails()) {
            return redirect()->back()
                ->withErrors($v->errors());
        }

        $access_link = AccessLink::find($request->input('link_id'));

        if ($access_link == null) {
            return redirect()->back()
                ->withErrors([
                    'Ссылка не найдена',
                ]);
        } elseif ($access_link->preset->source_id != Auth::user()->id) {
            return redirect()->back()
                ->withErrors([
                    'Ссылка не пренадлежит вам',
                ]);
        }

        $access_link->delete();

        return redirect()->back()
            ->with([
                'success_message' => 'Ссылка удалена',
            ]);
    }

    public function getActivateLink(Request $request) {
        $access_link = AccessLink::where('key', '=', $request->route('key'))->first();

        if ($access_link == null) {
            return view('access.activate_link')->withErrors([
                'Ссылка не найдена',
            ]);
        } elseif ($access_link->preset->source_id == Auth::user()->id) {
            return view('access.activate_link')->withErrors([
                'Вы не можете активировать свою ссылку',
            ]);
        } elseif ($access_link->status == AccessLink::USED_STATUS) {
            return view('access.activate_link')->withErrors([
                'Ссылка уже использована',
            ]);
        }

        $notify_access = new NotifyAccess;
        $notify_access->source_id = $access_link->preset->source_id;
        $notify_access->user_id = Auth::user()->id;
        $notify_access->status = NotifyAccess::ACTIVE_STATUS;

        if ($access_link->preset->forever) {
            $notify_access->access_type = NotifyAccess::PERMANENT_ACCESS;
        } else {
            $notify_access->access_type = NotifyAccess::LIMITED_ACCESS;
            $notify_access->end_at = Carbon::now()->addDays($access_link->preset->days);
        }

        $notify_access->save();

        $access_link->status = AccessLink::USED_STATUS;
        $access_link->save();

        return view('access.activate_link')->with([
            'access_link' => $access_link,
            'notify_access' => $notify_access,
        ]);
    }

    public function getDemo(Request $request) {
        if ($request->route('user_id') == Auth::user()->id) {
            return view('access.demo')->withErrors([
                'Вы не можете запросить демо доступ у себя',
            ]);
        }

        $access_presets = NotifyAccessPreset::where('source_id', '=', $request->route('user_id'))
            ->where('status', '=', NotifyAccessPreset::ACTIVE_STATUS)
            ->get();

        return view('access.demo')->with([
            'access_presets' => $access_presets,
            'user' => User::find($request->route('user_id')),
        ]);
    }

    public function postDemo(Request $request) {
        $v = Validator::make($request->all(), [
            'preset_id' => 'required|integer',
            'comment' => 'string|nullable',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $access_requests = AccessRequest::where('status', '=', AccessRequest::PROCESSING_STATUS)
            ->where('access_preset_id', '=', $request->input('preset_id'))
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        if (count($access_requests) > 0) {
            return redirect()->back()->withErrors([
                'Запрос доступа уже отправлен',
            ]);
        }

        $access_preset = NotifyAccessPreset::find($request->input('preset_id'));

        if ($access_preset == null) {
            return redirect()->back()->withErrors([
                'Доступ не найден',
            ]);
        } else if ($access_preset->source_id == Auth::user()->id) {
            return redirect()->back()->withErrors([
                'Вы не можете запросить демо доступ у себя',
            ]);
        } else if ($access_preset->status == NotifyAccessPreset::REMOVE_STATUS) {
            return redirect()->back()->withErrors([
                'Доступ удален',
            ]);
        }

        $access_request = new AccessRequest;
        $access_request->access_preset_id = $access_preset->id;
        $access_request->user_id = Auth::user()->id;
        $access_request->status = AccessRequest::PROCESSING_STATUS;
        $access_request->comment = $request->input('comment');
        $access_request->save();

        return redirect()->back()->with([
            'success_message' => 'Запрос отправлен',
        ]);
    }
}
