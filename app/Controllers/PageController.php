<?php

namespace App\Controllers;


class PageController
{
    public function dashboard()
    {
        return view("dashboard.view.php");
    }

    public function test()
    {
        return view("test.view.php");
    }
}
