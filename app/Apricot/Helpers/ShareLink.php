<?php


namespace App\Apricot\Helpers;


class ShareLink
{
    public static function get($id)
    {
        $hash = base64_encode($id);

        $link = url('/')."/flow?share=".$hash;

        return $link;
    }
}