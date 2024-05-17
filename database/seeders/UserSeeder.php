<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'MohamedlElsayed',
            'mobile_number' => '01027305928',
            'email' => 'moeid344@gmail.com',
            'password' => Hash::make('password123456'),
            'is_admin' => true
        ]);

        User::create([
            'username' => 'Ahmed',
            'mobile_number' => '9876543210',
            'email' => 'Ahmed@yahoo.com',
            'password' => Hash::make('password123654'),
            'is_admin' => false
        ]);

        User::create([
            'username' => 'Eman',
            'mobile_number' => '01027305927',
            'email' => 'Eman@yahoo.com',
            'password' => Hash::make('password123654'),
            'is_admin' => false
        ]);

    }
}
