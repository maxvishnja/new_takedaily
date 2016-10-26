<?php

namespace App\Console\Commands;

use App\Apricot\Libraries\MailFlowMatchmaker;
use App\Customer;
use App\MailFlow;
use Illuminate\Console\Command;

class MailFlowSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailflow:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate mailflow schedules, and send!';

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
        $mailflows = MailFlow::where('is_active', 1)->get();
        $matchmaker = new MailFlowMatchmaker;
        $customers = Customer::mailFlowable()->get();

        foreach($mailflows as $mailflow)
        {
        	$matchmaker->make($mailflow, $customers);
        }
    }
}
