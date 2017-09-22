<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Snoozing;

class SnoozingController extends Controller
{


    public function index(){

        $snoozing = Snoozing::orderBy('created_at', 'DESC')->get();

        return view('admin.snoozing.index', [
            'snoozing' => $snoozing,
        ]);

    }

}