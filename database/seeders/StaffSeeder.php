<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::create([
            'name' => 'First Staff',
            'email' => 'staff1@test.com',
            'password' => Hash::make('password')
        ]);

        Staff::create([
            'name' => 'Second Staff',
            'email' => 'staff2@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
