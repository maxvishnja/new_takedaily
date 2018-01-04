<?php

namespace App\Console\Commands;

use App\AlmostCustomers;
use App\Apricot\Helpers\FacebookApiHelper;
use App\Plan;
use Illuminate\Console\Command;


class AddManualFb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fb:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update customers FB API';

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


        $plansActiveNl = Plan::where('currency','=', 'EUR')->whereNull('subscription_cancelled_at')->get();

        $plansActiveDk = Plan::where('currency','=', 'DKK')->whereNull('subscription_cancelled_at')->get();

        $plansNotActiveNl = Plan::where('currency','=', 'DKK')->whereNotNull('subscription_cancelled_at')->get();

        $plansNotActiveDk = Plan::where('currency','=', 'DKK')->whereNotNull('subscription_cancelled_at')->get();

        $almostNl = AlmostCustomers::where('location', '=', 'nl')->get();

        $almostDk = AlmostCustomers::where('location', '=', 'da')->get();

        $query = new FacebookApiHelper();


        try{

            $query->addRealUsers(config('services.fbApi.nl_active'), $plansActiveNl, 'NL');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }


        try{

            $query->addRealUsers(config('services.fbApi.dk_active'), $plansActiveDk, 'DA');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }

        try{

            $query->addRealUsers(config('services.fbApi.nl_not_active'), $plansNotActiveDk, 'DA');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }


        try{

            $query->addRealUsers(config('services.fbApi.dk_not_active'), $plansNotActiveNl, 'NL');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }

        try{

            $query->addAlmostUsers(config('services.fbApi.almost_dk'), $almostDk, 'DA');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }


        try{

            $query->addAlmostUsers(config('services.fbApi.almost_nl'), $almostNl, 'NL');

        } catch (\Exception $exception) {

            \Log::error("Error in  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }

    }



}