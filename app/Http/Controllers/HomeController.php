<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function guest_show(){
        return view('home-guest');
    }

    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('home');
    }
}
