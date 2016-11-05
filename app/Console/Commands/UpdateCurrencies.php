<?php

namespace App\Console\Commands;

use App\Apricot\Libraries\MoneyLibrary;
use App\Currency;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the currencies';

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
	    try
	    {
		    $client   = new Client();
		    $response = $client->get('http://api.fixer.io/latest?base=' . \Config::get('app.base_currency'));

		    $content = $response->getBody()->getContents();

		    $content = json_decode($content);

		    Currency::create([
			    'name' => \Config::get('app.base_currency'),
			    'rate' => MoneyLibrary::toCurrencyRate(1.0000)
		    ]);

		    foreach ( $content->rates as $rateName => $rate )
		    {
			    Currency::create([
				    'name' => $rateName,
				    'rate' => MoneyLibrary::toCurrencyRate($rate)
			    ]);
		    }

		    //\Cache::flush(); // todo only flush currency cache

	    } catch (\Error $ex){
		    \Log::error('Could not get currencies: ' . $ex->getMessage());
	    }
    }
}
