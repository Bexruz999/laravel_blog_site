<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TLE;

class LogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:log-command';

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
        try {

            print_r($a);

        } catch (\Exception $e) {
            TLE::exp($e)->send();
        }
    }
}
