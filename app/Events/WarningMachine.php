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

class WarningMachine
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $warning ;
    public function __construct(Machine $machine)
    {
        //
        $this -> warning = $machine;
        if($machine->user->role != Role::ADMIN){
            $this -> postwarning($this ->warning );}
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

    // todo insert warning in this machine //
    public function postwarning($warning){
        if($warning ->warning == 5){
            $warning -> warning = null ;
            $warning -> save();
        }else{
            $warning -> warning = $warning->warning +1 ;
            $warning -> save();
        }
    }
}
