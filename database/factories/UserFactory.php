<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Generate the created_at date...
        $create_date = $this->faker->dateTimeBetween(startDate: '-5 years');
        // ...and (possibly) an updated_at date
        $update_date = null;
        // 50% chance of updated date
        if (random_int(0, 1) === 1) {
            $update_date = $this->faker->dateTimeThisYear();
        }

        // return new database record (row) to seed
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'site_admin' => false,
            'system_admin' => null,
            // default 'Model' attributes for 'published' and 'edited'
            'created_at' => $create_date,
            'updated_at' => $update_date,
        ];
    }
}
