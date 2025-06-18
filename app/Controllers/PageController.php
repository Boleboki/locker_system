<?php

namespace App\Controllers;


class PageController
{


    public function dashboard()
    {
        view("dashboard.view.php");
    }

    public function test()
    {
        view("test.view.php");
    }
}
