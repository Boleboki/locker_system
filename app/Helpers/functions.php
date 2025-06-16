<?php

use App\Core\Response;

function dd($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function abort($code = 404){
    http_response_code($code);
    require base_path("app/views/{$code}.php");
    die();
}

function base_path($path){
    return BASE_PATH . $path;
}

function view($path, $attributes = []){
    extract($attributes);
    require base_path('app/views/' . $path);
}

function redirect($path){
    header("Location: {$path}");
    exit();
}

