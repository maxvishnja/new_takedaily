<?php

namespace App\Console\Commands;

use App\Coupon;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class ClearOldCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old coupons';

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
        //Coupon::where('valid_to', '<=', Date::now()->subDays(7))->delete();

    }
}
