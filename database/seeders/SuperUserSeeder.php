<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sinanismailaidris@gmail.com'],
            [
                'name' => 'Super User',
                'password' => Hash::make('Sinan3367#'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
            ]
        );
    }
}
