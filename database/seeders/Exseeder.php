<?php

namespace Database\Seeders;



use App\Models\Executive;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Exseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Executive::create([
        //     'name' => 'Sabbir Executive',
        //     'email' => 'executive9@test.com',
        //     'password' => Hash::make('password')
        // ]);

        Staff::create([
            'name' => 'Sabbir Staff',
            'email' => 'staff9@test.com',
            'password' => Hash::make('password')
        ]);
    }
}

