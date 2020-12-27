<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Custom import
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call User factory
        User::factory(60)->create();
    }
}
