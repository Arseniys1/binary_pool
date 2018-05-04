<?php

use App\Broadcasting\TestChannel;
use App\Broadcasting\Chat;
use App\Broadcasting\User;

Broadcast::channel('test-channel', TestChannel::class);

Broadcast::channel('chat.{id}', Chat::class);

Broadcast::channel('user.{user_id}', User::class);
