<?php

namespace Database\Seeders;

use App\Models\Approver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApproverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Approver::create([
            'name' => 'First Approver',
            'email' => 'approver1@test.com',
            'password' => Hash::make('password')
        ]);

        Approver::create([
            'name' => 'Second Approver',
            'email' => 'approver2@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
