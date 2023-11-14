<?php

namespace App\Listeners;

use App\Events\PostsVieweer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseVieweer
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostsVieweer $event): void
    {
        //
        //$this -> updateVieweer($event -> views);

    }

    function updateVieweer($views){
        
        $views -> view = $views -> view + 1;
        $views -> save();
    }
}
