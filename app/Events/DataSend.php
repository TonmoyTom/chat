<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\PrivateMessage;

class DataSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $privateMessage;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PrivateMessage $privateMessage)
    {
       $this->privateMessage = $privateMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('private.'.$this->privateMessage->to);
    }

    public function broadcastWith()
    {
        $this->privateMessage->load('fromContact');
        return ["message" => $this->privateMessage];
    }
}
