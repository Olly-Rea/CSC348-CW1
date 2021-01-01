<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // If authorised, go to main feed
        if(Auth::check()) {
            return redirect('/feed');
        } else {
            return view('welcome');
        }
    }

}
