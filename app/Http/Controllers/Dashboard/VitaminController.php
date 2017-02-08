<?php
namespace app\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;


class VitaminController extends Controller
{

    function index()
    {

        $count = \App\Apricot\Helpers\AllVitamins::getCountVitamins();

        return view('admin.vitamins.home', [
            'vitamins' => $count
        ]);
    }


}