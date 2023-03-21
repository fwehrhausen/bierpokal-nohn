<?php

namespace App\Events;

use App\Models\Club;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeterBeerSoldEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Club $club;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Club $club)
    {
        $this->club = $club;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('meter-beer-sold');
    }
}
