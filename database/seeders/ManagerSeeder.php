<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manager::create([
            'name' => 'First Manager',
            'email' => 'manager1@test.com',
            'password' => Hash::make('password')
        ]);

        Manager::create([
            'name' => 'Second Manager',
            'email' => 'manager2@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
