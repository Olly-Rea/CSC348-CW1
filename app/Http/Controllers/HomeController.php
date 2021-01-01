<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

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

    /**
     * Method to make a notification read
     */
    public static function notifyRead(Request $request) {
        if ($request->ajax()) {
            // Mark the notification as read
            Auth::user()->notifications->where('id', $request->id)->markAsRead();
            return true;
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to delete a notification
     */
    public static function notifyDelete(Request $request) {
        if ($request->ajax()) {
            // Mark the notification as read
            Auth::user()->notifications()->where('id', $request->id)->delete();
            return true;
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

}
