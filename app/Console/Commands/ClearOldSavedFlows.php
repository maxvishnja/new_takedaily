<?php

namespace App\Console\Commands;

use App\SavedFlowState;
use Illuminate\Console\Command;

class ClearOldSavedFlows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearold:flows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old flows';

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
	    SavedFlowState::where('updated_at', '<=', Date::now()->subDays(2))->delete();
    }
}
