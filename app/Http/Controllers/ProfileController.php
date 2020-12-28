<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{

    /**
     * Method to load the profile image for a 'User' model
     */
    public static function loadImage($path) {
        $imagePath = 'storage'.DIRECTORY_SEPARATOR.$path;
        // Check the file exists, and if so, output it, otherwise, return the image placeholder
        if (file_exists(public_path().DIRECTORY_SEPARATOR.$imagePath)) {
            return asset($imagePath);
        } else {
            clearstatcache();
            return asset('/images/profile-default.png');
        }
    }

    public static function show(User $user) {
        if(Auth::check() && Auth::user()->id == $user->id) {
            redirect('/me');
        } else {
            return view('profile', ['user' => $user]);
        }

    }

    public static function me() {
        return view('profile', ['user' => Auth::user()]);
    }

}
