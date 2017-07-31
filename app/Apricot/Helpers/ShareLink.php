<?php


namespace App\Apricot\Helpers;


class ShareLink
{
    public static function get($id)
    {
        $hash = base64_encode($id);

        $link = "https://takedaily.".\App::getLocale()."/flow?share=".$hash;

        return $link;
    }
}