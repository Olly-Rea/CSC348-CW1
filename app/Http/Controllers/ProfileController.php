<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Method to load the profile image for a 'User' model.
     *
     * @param mixed $path
     */
    public static function loadImage($path)
    {
        if ($path !== null) {
            $imagePath = 'storage' . DIRECTORY_SEPARATOR . $path;
            // Check the file exists, and if so, output it, otherwise, return the image placeholder
            if (file_exists(public_path() . DIRECTORY_SEPARATOR . $imagePath)) {
                return secure_asset($imagePath);
            } else {
                clearstatcache();

                return secure_asset('images/profile-default.svg');
            }
        } else {
            clearstatcache();

            return secure_asset('images/profile-default.svg');
        }
    }

    /**
     * Method to show a User's profile.
     */
    public static function show(User $user)
    {
        if (Auth::check() && Auth::user()->id === $user->id) {
            return redirect('/Me');
        } else {
            return view('profile.show', ['user' => $user]);
        }
    }

    /**
     * Method to show the Auth User's profile.
     */
    public static function me()
    {
        if (Auth::check()) {
            return view('profile.show', ['user' => Auth::user()]);
        } else {
            // Return forbidden
            abort(403);
        }
    }

    /**
     * Method to update a users profile.
     */
    public static function update()
    {
        // Ensure the user is logged in
        if (Auth::check()) {
            // Get the $user and $profile from the Auth User
            $user = Auth::user();
            $profile = $user->profile;

            // Set Validator attribute names
            $attributeNames = [
                'profile_image' => 'Profile Image',
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'about_me' => 'About Me',
            ];
            // Validate the data
            Validator::make(request()->all(), [
                'profile_image' => ['image', 'mimes:jpeg,png,jpg,bmp', 'nullable'],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['string', 'max:255', 'nullable'],
                'about_me' => ['string', 'nullable'],
            ], [], $attributeNames)->validateWithBag('me');

            // Update the user information
            $user->update([
                'first_name' => request('first_name') !== null ? request('first_name') : $user->first_name,
                'last_name' => request('last_name') !== null ? request('last_name') : $user->last_name,
            ]);

            // Check if the user has uploaded a profile image in the request
            if (is_uploaded_file(request('profile_image'))) {
                // Delete the currently stored file (if any)
                if (Storage::exists($profile->profile_image)) {
                    Storage::delete($profile->profile_image);
                }

                // Set $image as the input file
                $image = request('profile_image');
                // Set the imagePath
                $imagePath = 'user_uploads/users/' . $user->id . '/';
                // Set the image name (with it's original extension)
                $name = 'profile_image.' . $image->getClientOriginalExtension();
                // Get the full path, and move the file to that directory
                $destinationPath = public_path() . '/storage/' . $imagePath;
                $image->move($destinationPath, $name);

                // Get the file path to store in the database)
                $filePath = $imagePath . $name;

                // Update profile information
                $profile->update([
                    'about_me' => request('about_me') !== null ? request('about_me') : $profile->about_me,
                    'profile_image' => $filePath,
                ]);
            } else {
                // Update profile information
                $profile->update([
                    'about_me' => request('about_me') !== null ? request('about_me') : $profile->about_me,
                ]);
            }

            return redirect('Me');
        } else {
            // Return forbidden
            abort(403);
        }
    }

    /**
     * Method to delete a profile (and all associated information).
     */
    public static function delete()
    {
        // Ensure a user is logged in
        if (Auth::check()) {
            // Get the user
            $user = User::find(Auth::user())->first();

            // Delete the user profile image directory from the server
            Storage::deleteDirectory('user_uploads/users/' . $user->id);
            // Delete any tokens the User has
            $user->tokens->each->delete();
            // Delete any notifications the user has
            $user->notifications()->delete();

            dd($user);

            // delete the user itself (relationships deleted by cascade)
            $user->delete();

            // return the guest to the welcome page
            return redirect('/');
        } else {
            // Return forbidden
            abort(403);
        }
    }

    /**
     * Method to fetch a profile's about info.
     */
    public static function fetchAbout(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('id', $request->user_id)->first();

            return $user->profile->about_me;
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to fetch a User's posts.
     */
    public static function fetchPosts(Request $request)
    {
        if ($request->ajax()) {
            // Get the next page of this users paginated posts
            $user = User::where('id', $request->user_id)->first();
            $posts = $user->posts->orderBy('created_at', 'DESC')->paginate(12);

            if (\count($posts) === 0) {
                return null;
            } else {
                // render the posts and return them to the feed
                return view('paginations.posts', ['posts' => $posts])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to fetch all the User's likeable elements.
     */
    public static function fetchLikes(Request $request)
    {
        if ($request->ajax() && str_contains($request->url(), 'Me')) {
            // Get the next page of this users paginated posts
            $posts = Auth::user()->posts->orderBy('created_at', 'DESC')->paginate(12);

            if (\count($posts) === 0) {
                return null;
            } else {
                // render the posts and return them to the TalentFeed
                return view('paginations.posts', ['posts' => $posts])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }
}
