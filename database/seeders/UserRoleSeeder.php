<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user (no roles)
        User::updateOrCreate(
            ['email' => 'user@siakra.com'],
            [
                'name' => 'User SIAKRA',
                'email' => 'user@siakra.com',
                'password' => Hash::make('user123'),
            ]
        );

        // Do not manipulate the 'role' column anymore.
        $this->command->info('Default user created: user@siakra.com / user123');
    }
}
