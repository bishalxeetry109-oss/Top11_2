<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BallUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function broadcastOn()
    {
        return new Channel('match.' . $this->payload['match_id']);
    }

    public function broadcastAs()
    {
        return 'ball.updated';
    }

    public function broadcastWith()
    {
        return $this->payload;
    }
}