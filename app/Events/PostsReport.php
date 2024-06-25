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

class PostsReport
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $reports;
    public function __construct(Post $post)
    {
        //
        $this -> reports = $post;
        if(auth()->user()->role != Role::ADMIN){
        $this -> updateReport($this -> reports);}
        else{$this -> skipReport($this -> reports);}
      

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

    // todo skip report change column report on null // 
    function skipReport($reports){
        if($reports -> skip == true){
        $reports -> report = null;
        }else{}
    }

    // todo change num report post // 
    function updateReport($reports){
        if($reports -> skip != true){
            $reports -> report = $reports -> report + 1;
        }
        else{}
        unset($reports['skip']);
        $reports -> save();
    }
}
