<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fname' => 'First',
            'lname' => 'User',
            'email' => 'user1@test.com',
            'phone' => '019xxxxxxxx',
            'password' => Hash::make('password')
        ]);

        User::create([
            'fname' => 'Second',
            'lname' => 'User',
            'email' => 'user2@test.com',
            'phone' => '017xxxxxxxx',
            'password' => Hash::make('password')
        ]);
    }
}
