<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $id;
    public $user;
    public $text;
    public $created_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $user, $text)
    {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
        $this->created_at = Carbon::now()->timestamp;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat.' . $this->id);
    }

}
