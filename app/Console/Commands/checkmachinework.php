<?php

namespace App\Console\Commands;

use App\Traits\ErrorTrait;
use Illuminate\Console\Command;

class checkmachinework extends Command
{
    use ErrorTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machine:checkwork';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if machine work or not and send mail & insert data normally';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $checkwork = $this->checkwork();

    }
}
