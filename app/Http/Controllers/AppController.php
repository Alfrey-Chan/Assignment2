<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function notFound()
    {
        return view('errors.404');
    }
}
