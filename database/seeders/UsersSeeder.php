<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::first() == null) {
            User::factory(1)->create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password')
            ]);
        }
    }
}
