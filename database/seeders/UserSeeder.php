<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = new User();
        $user1->username = "player1";
        $user1->password = Hash::make("helloworld1!");
        $user1->save();


        $user2 = new User();
        $user2->username = "player2";
        $user2->password = Hash::make("helloworld2!");
        $user2->save();


        $user3 = new User();
        $user3->username = "dev1";
        $user3->password = Hash::make("hellobyte1!");
        $user3->save();

        $user4 = new User();
        $user4->username = "dev2";
        $user4->password = Hash::make("hellobyte2!");
        $user4->save();


    }
}
