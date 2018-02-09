<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Nutritionist;
use Illuminate\Console\Command;

class CheckDietologs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:dietologs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add dietologs to Customer';

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
        $repo = new CustomerRepository();

        $customers = $repo->all();

        $dietist_nl = Nutritionist::where('locale','=','nl')->where('active','=',1)->first();
        $dietist_dk = Nutritionist::where('locale','=','da')->where('active','=',1)->first();

        foreach ($customers as $customer){

            if($customer->getLocale() == 'nl'){
                $customer->plan->nutritionist_id = $dietist_nl->id;
            } else{
                $customer->plan->nutritionist_id = $dietist_dk->id;
            }

            $customer->plan->save();
        }

        return "Ok";
    }

}
