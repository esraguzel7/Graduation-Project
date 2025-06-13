<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('dashboard');
    }
}
