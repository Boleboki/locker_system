<?php

namespace App\Controllers;


class PageController {
    public function login(){
        return view("index.view.php");
    }

    public function dashboard(){
        view("dashboard.view.php");
    }

    public function test(){
        view("test.view.php");
    }
}