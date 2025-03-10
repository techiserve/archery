<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        // Insert a single user
        User::create([
            'name' => 'Vincent', // Change name as needed
            'email' => 'v.mhokore@techiserve.com', // Change email as needed
            'password' => Hash::make('password12345678'), // Make sure the password is hashed
        ]);
    }
}
