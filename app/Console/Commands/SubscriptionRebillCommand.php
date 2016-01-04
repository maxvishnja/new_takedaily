<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubscriptionRebillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:rebill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charges customers cards';

    /**
     * Create a new command instance.
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
        //
    }
}
