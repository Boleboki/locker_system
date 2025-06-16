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
        $method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

        Router::route($uri, $method);
    }
}
