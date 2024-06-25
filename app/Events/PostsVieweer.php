<?php

namespace App\Events;

use App\Models\Post;
use App\Models\Role;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostsVieweer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $views;
    public function __construct(Post $post)
    {
        //
        $this -> views = $post;
        if(auth()->user()->role != Role::ADMIN){
        $this -> updateVieweer($this -> views);}
        else{
            
        }        

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

    // todo change num watcheing post // 
    function updateVieweer($views){
        
        $views -> view = $views -> view + 1;
        $views -> save();
    }
}
