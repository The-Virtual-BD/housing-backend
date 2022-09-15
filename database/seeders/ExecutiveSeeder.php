<?php

namespace Database\Seeders;

use App\Models\Executive;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExecutiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Executive::create([
            'name' => 'First Executive',
            'email' => 'executive1@test.com',
            'password' => Hash::make('password')
        ]);

        Executive::create([
            'name' => 'Second Executive',
            'email' => 'executive2@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
