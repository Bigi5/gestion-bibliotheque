<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Inspiring;
use Illuminate\Console\Command;

class InspireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment(Inspiring::quote());
    }
}
