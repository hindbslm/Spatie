<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Hind Bouslama',
            'email' => 'hind@bouslama.com',
            'password' => Hash::make('hind1234')
        ]);

        $admin->assignRole('Admin');

        $user = User::create([
            'name' => 'Test Test',
            'email' => 'test@test.com',
            'password' => Hash::make('test1234')
        ]);

        $user->assignRole('User');
    }
}
