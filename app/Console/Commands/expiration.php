<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Revive;
use App\Models\Tourism;
use Illuminate\Console\Command;

class expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revive:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire data every 24 hours automatically where insert from revive|tourism';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //todo collection of Revives
        $revives = Revive::where('expire',0)->get();
        foreach ($revives as $revive) {
            $revive -> update(['expire' => 1]);
        }

        //! Tourism //
        //todo collection of Tourism
        $tourisms = Tourism::where('expire',0)->get();
        foreach ($tourisms as $tourism) {
            $tourism -> update(['expire' => 1]);
        }
    }
}
