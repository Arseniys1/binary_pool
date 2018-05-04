<?php

namespace App\Broadcasting;

use App\User;
use App\Helpers\ChatHelper;

class Chat
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, $id)
    {
        if (ChatHelper::hasAccessToChat($user, $id)) {
            return $user->toArray();
        } else {
            return false;
        }
    }

}
