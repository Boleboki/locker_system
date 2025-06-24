<?php

namespace App\Core;

class App
{
    public function __construct()
    {
        Session::start();

        require_once BASE_PATH . "config.php";
        require_once BASE_PATH . "app/Helpers/functions.php";
        require_once BASE_PATH . "routes.php";
    }

    public function run(): void
    {
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);   // npr. /ormarici/public
        $basePath = str_replace('/public', '', $scriptName); // → /ormarici

        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        $uri = $uri ?: '/';
        $method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];
        Router::route($uri, $method);
    }
}
