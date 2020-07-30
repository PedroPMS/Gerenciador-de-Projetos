<?php

namespace App\lib;

class Twig {

    public static function load(): \Twig\Environment
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'\..\view');
        $twig = new \Twig\Environment($loader);

        return $twig;
    }
}