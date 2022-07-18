<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Md. Saiful Islam',
            'email' => 'api@lumen.com',
            'role' => 'admin',
            'password' => Hash::make('12345678')
        ]);
    }
}
