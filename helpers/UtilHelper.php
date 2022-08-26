<?php

namespace app\helpers;

class UtilHelper
{
    # useful methods
    public static function randomString($stringLength)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = "";
        for ($i = 0; $i < $stringLength; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $string .= $characters[$index];
        }
        return $string;
    }
}