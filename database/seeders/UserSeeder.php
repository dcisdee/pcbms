<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Personnel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all personnel IDs from the database
        $personnels = Personnel::all();

        foreach($personnels as $personnel) {
            User::create([
                'email' => $personnel->email,
                'password' => bcrypt('password'),
                'personnel_id' => $personnel->id,
                'is_admin' => $personnel->is_admin,
            ]);
        }
    }
}
