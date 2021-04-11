<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function welcome()
    {
        return view('welcome');
    }

    public function news()
    {
        return "News";
    }

    public function view($id = '')
    {
        return 'News #' . $id;
    }
}
