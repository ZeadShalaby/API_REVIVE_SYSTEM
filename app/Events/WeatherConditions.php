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

class WeatherConditions
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $weather ;
    public function __construct(Machine $machine)
    {
        
        $this -> weather = $machine;
        if($machine->user->role != Role::ADMIN){
            $this -> postweather($this ->weather );}
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

    // todo insert weather condation in this machine //
    public function postweather($weather){
        
            $weather -> weather = $weather->condation ;
            unset($weather['condation']);
            $weather -> save();
        
    }
}
