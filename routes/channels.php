<?php

use App\Broadcasting\TestChannel;

Broadcast::channel('test-channel', TestChannel::class);
