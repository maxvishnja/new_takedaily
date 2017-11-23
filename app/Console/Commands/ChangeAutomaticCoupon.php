<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CouponRepository;
use Illuminate\Console\Command;

class ChangeAutomaticCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change automatic coupon code';

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

        $repo = new CouponRepository();

        $couponsNL = $repo->AutomaticNL();

        $couponsDK = $repo->AutomaticDK();


        foreach($couponsNL as $coupon){

            if($coupon->automatic_id  == '50first'){
                $coupon->code = strtoupper("NL50".substr(md5(uniqid()), 0, 5));
            }
            if($coupon->automatic_id  == '100first'){
                $coupon->code = strtoupper("NL100".substr(md5(uniqid()), 0, 5));
            }
            if($coupon->automatic_id  == '20sub'){
                $coupon->code = strtoupper("SUB20NL".substr(md5(uniqid()), 0, 5));
            }

            $coupon->save();

        }

        foreach($couponsDK as $coupon){

            if($coupon->automatic_id  == '50first'){
                $coupon->code = strtoupper("DK50".substr(md5(uniqid()), 0, 5));
            }
            if($coupon->automatic_id  == '100first'){
                $coupon->code = strtoupper("DK100".substr(md5(uniqid()), 0, 5));
            }
            if($coupon->automatic_id  == '20sub'){
                $coupon->code = strtoupper("SUB20DK".substr(md5(uniqid()), 0, 5));
            }

            $coupon->save();

        }

    }
}
