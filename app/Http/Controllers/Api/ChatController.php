<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Events\ChatMessage;
use App\Http\Controllers\Api\ApiController;
use App\Helpers\ChatHelper;
use Auth;
use Validator;

class ChatController extends ApiController
{
    public function postSendMessage(Request $request) {
        $v = Validator::make($request->all(), [
            'id' => 'required|string',
            'text' => 'required|string',
        ]);

        if ($v->fails()) {
            return $this->error_response($v->errors());
        }

        if (ChatHelper::hasAccessToChat(Auth::user(), $request->input('id')) == false) {
            return $this->error_response('no access to chat');
        }

        broadcast(new ChatMessage($request->input('id'), Auth::user(), $request->input('text')));

        return $this->success_response('message sent');
    }

    public function postOpenChat(Request $request) {
        $v = Validator::make($request->all(), [
            'id' => 'required|string',
            'text' => 'required|string',
        ]);

        if ($v->fails()) {
            return $this->error_response($v->errors());
        }

        ChatHelper::openChat($request->input('id'), $request->input('text'));

        return $this->success_response('chat opened');
    }

}
