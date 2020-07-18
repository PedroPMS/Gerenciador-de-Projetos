<?php

namespace App\Factories;

class GenerateData
{
    public static function generateString($len): String
    {
        $string     = '';
        $vowels     = array("a", "e", "i", "o", "u");
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        );

        // Seed it
        srand((float) microtime() * 1000000);

        $max = $len / 2;
        for ($i = 1; $i <= $max; $i++) {
            $string .= $consonants[rand(0, 19)];
            $string .= $vowels[rand(0, 4)];
        }

        return $string;
    }

    public static function generateDate($interval): String
    {
        $start = strtotime($interval[0]);
        //$start = strtotime("01 January 2019");
        $end = strtotime($interval[1]);
        //$end = strtotime("01 January 2019")
        $timestamp = mt_rand($start,$end);
        $date = date("Y-m-d", $timestamp);
        return $date;
    }

    public static function generateInt(): int
    {
        return rand(1,255);
    }

    public static function generateBoolean(): int
    {
        return rand(0,1);
    }
}