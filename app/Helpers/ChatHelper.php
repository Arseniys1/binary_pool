<?php

namespace App\Helpers;

use App\User;
use App\Models\NotifyAccess;
use App\Events\UserEvent;

class ChatHelper
{
    public static function getChatType($id) {
        if (count(explode('-', $id)) < 2) {
            return 'public';
        } else {
            return 'private';
        }
    }

    public static function getChatInitId($id) {
        return self::explodeId($id)[0];
    }

    public static function getChatCalledId($id) {
        return self::explodeId($id)[1];
    }

    public static function openChat($id, $text) {
        broadcast(
            new UserEvent(
                self::getChatCalledId($id),
                [
                    'event' => 'newChat',
                    'data' => [
                        'id' => $id,
                        'text' => $text,
                    ],
                ]
            )
        );
    }

    public static function hasAccessToChat($user, $id) {
        if (self::getChatType($id) == 'public') {
            return self::hasAccessToPublicChat($user, $id);
        } elseif (self::getChatType($id) == 'private') {
            return self::hasAccessToPrivateChat($id);
        }

        return false;
    }

    private static function explodeId($id) {
        return explode('-', $id);
    }

    private static function hasAccessToPublicChat($user, $id) {
        if ($user->id == $id) {
            return true;
        } else {
            $notify_access = NotifyAccess::where('user_id', '=', $user->id)
                ->where('source_id', '=', $id)
                ->where('status', '=', NotifyAccess::ACTIVE_STATUS)
                ->first();

            if ($notify_access != null) {
                return true;
            }
        }

        return false;
    }

    private static function hasAccessToPrivateChat($id) {
        $ids = explode('-', $id);

        if (count($ids) < 2 || count($ids) > 2) {
            return false;
        } else if (User::whereIn('id', $ids)->get()->count() < 2) {
            return false;
        }

        return true;
    }

}