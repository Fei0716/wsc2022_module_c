<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin1 = new User();
        $admin1->username = "admin1";
        $admin1->password = Hash::make("hellouniverse1!");
        $admin1->role = "admin";
        $admin1->save();


        $admin2 = new User();
        $admin2->username = "admin2";
        $admin2->password = Hash::make("hellouniverse2!");
        $admin2->role = "admin";
        $admin2->save();
    }
}
