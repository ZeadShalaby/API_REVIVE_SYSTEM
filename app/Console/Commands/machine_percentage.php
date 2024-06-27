<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Percentage\PercentageTrait\PercentageTrait;

class machine_percentage extends Command
{
    use PercentageTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machine:percentage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'after one year clear the total carbon fotprint of column total_CF in table machine to restart again in beging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ? to check if the data its gone or no  at 'one year'
        $NewPercentage = $this->StartNewPercentage();
    }
}
