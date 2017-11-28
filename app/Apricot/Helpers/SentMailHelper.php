<?php

namespace App\Apricot\Helpers;


use App\MailStat;

class SentMailHelper
{

    public static function getDate($i){


        return \Date::now()->subDay($i)->format('d-m-Y');


    }


    public static function getCountMail($i, $cat){

        $count = MailStat::whereDate('created_at','=',\Date::now()->subDay($i)->format('Y-m-d'))->where('mail_cat','=',$cat)->count();

        return $count;

    }







}




