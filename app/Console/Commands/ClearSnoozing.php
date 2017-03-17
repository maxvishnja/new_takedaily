<?php

namespace App\Console\Commands;

use App\Snoozing;
use Illuminate\Console\Command;

class ClearSnoozing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:snoozing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old snoozing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Snoozing::where('created_at', '<=', \Date::now()->subDays(28))->delete();
    }
}
