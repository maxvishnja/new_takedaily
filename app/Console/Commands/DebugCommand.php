<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 13.10.17
 * Time: 8:59
 */

namespace App\Console\Commands;


use App\Customer;
use App\Nutritionist;
use App\Plan;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class DebugCommand extends Command
{
    protected $signature = 'td:debug';

    public function handle()
    {
        echo "<pre>";
        var_dump(DNS1D::getBarcodePNGUri("00057126960000000015", "C128",3,33, true));
        var_dump(DNS1D::getBarcodePNGUri("4", "C39+",3,33,array(1,1,1), true));
        var_dump(DNS1D::getBarcodePNGUri("4445645656", "PHARMA2T",3,33,array(255,255,0), true));
        var_dump(DNS1D::getBarcodePNGUri("455", "C39+",3,33,array(1,1,1)));
        echo "</pre>";
    }
}