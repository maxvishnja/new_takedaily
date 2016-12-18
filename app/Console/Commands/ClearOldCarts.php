<?php

namespace App\Console\Commands;

use App\Cart;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class ClearOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clearing old carts';

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
        Cart::where('updated_at', '<=', Date::now()->subDays(2))->delete();
    }
}
