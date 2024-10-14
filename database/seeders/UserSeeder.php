<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Maged Mamdouh',
            'email'=>'maged22@gmail.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'01000899'
        ]);
        DB::table('users')->insert([
            'name'=>'Maged Admin',
            'email'=>'magedadmin@gmail.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'0100088899'
        ]);
    }
}
