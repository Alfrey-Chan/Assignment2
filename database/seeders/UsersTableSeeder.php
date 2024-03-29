<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => bcrypt(config('admin.password')),
            'approved' => true,
        ]);

        User::create([
            'name' => 'banana',
            'email' => 'banana@test.com',
            'password' => '12345678',
        ]);
        User::create([
            'name' => 'apple',
            'email' => 'apple@test.com',
            'password' => '12345678',
        ]);
        User::create([
            'name' => 'cranberry',
            'email' => 'cranberry@test.com',
            'password' => '12345678',
        ]);
        User::create([
            'name' => 'grape',
            'email' => 'grape@test.com',
            'password' => '12345678',
        ]);
    }
}
