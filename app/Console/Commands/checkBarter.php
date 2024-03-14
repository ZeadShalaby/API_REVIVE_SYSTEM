<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Barter\BarterTrait;

class checkBarter extends Command
{
    use BarterTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-barter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $BarterDaily = $this->BarterDaily();
    }
}
