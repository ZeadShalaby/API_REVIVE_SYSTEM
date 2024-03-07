<?php

namespace App\Events;

use App\Models\Role;
use App\Models\Machine;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CarbonFootprint
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $ratio ;
    public function __construct(Machine $machine)
    {
         // todo change or insert ratio carbon footprint //
        $this -> ratio = $machine;
        if($machine->user->role != Role::ADMIN){
        $this -> postratio($this ->ratio );}
        else{}  
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

     // todo add new ratio (Carbon Footprint Factory) in this machine  //
     public function postratio($ratio){
        
        $ratio -> carbon_footprint = $ratio ->ratio;
        unset($ratio['ratio'],$ratio['date']);
        $ratio -> save();
    }
}
