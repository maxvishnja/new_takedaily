<?php

namespace App\Console\Commands;

use App\AlmostCustomers;
use App\SavedFlowState;
use App\User;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class ClearOldSavedFlows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:flows';

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
	    //SavedFlowState::where('updated_at', '<=', Date::now()->subDays(28))->delete();

	    $almosts = AlmostCustomers::orderBy('created_at', 'DESC')->get();
	    $customers = User::orderBy('created_at', 'DESC')->get();

	    foreach ($almosts as $almost){
	        foreach($customers as $customer){
	            if($almost['email'] == $customer['email']){
                    $almost->delete();
                }
            }
        }
    }
}
