<?php

namespace App\Actions\Fortify;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        // Validate the input
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        // Split the user name input into first and last name
        $name = explode(' ', ucwords($input['name']));
        $first_name = $name[0];
        if (\count($name) === 2) {
            $last_name = $name[1];
        } else {
            $last_name = null;
        }

        // Create the new user
        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'site_admin' => false,
        ]);

        // dd($user->id);

        // Create the new User's Profile
        Profile::create([
            'user_id' => $user->id,
            'about_me' => null,
            'profile_image' => null,
        ]);

        // return the User
        return $user;
    }
}
