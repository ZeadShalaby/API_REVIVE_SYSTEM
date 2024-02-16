<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FootprintPeople
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $ratio ;
    public function __construct(User $user)
    {
        //
         // todo change or insert ratio carbon footprint //
         $this -> ratio = $user;
         $this -> postratio($this ->ratio );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

     // todo add new ratio (Carbon Footprint Person)   //
     public function postratio($ratio){
        $ratio -> carbon_footprint = $ratio ->ratio;
        unset($ratio['ratio']);
        $ratio -> save();
    }
}
