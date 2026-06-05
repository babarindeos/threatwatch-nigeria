<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::firstOrCreate(
            ['email' => 'admin@threatwatch.ng'],
            [
                'firstname'         => 'ThreatWatch',
                'surname'           => 'Admin',
                'email'             => 'admin@threatwatch.ng',
                'password'          => Hash::make('Admin@12345'),
                'role'              => 'super_admin',
                'phone'             => '+2348000000001',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );

        // Moderator
        User::firstOrCreate(
            ['email' => 'mod@threatwatch.ng'],
            [
                'firstname'         => 'Chidi',
                'surname'           => 'Okafor',
                'email'             => 'mod@threatwatch.ng',
                'password'          => Hash::make('Mod@12345'),
                'role'              => 'moderator',
                'phone'             => '+2348000000002',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );

        // Demo regular user
        User::firstOrCreate(
            ['email' => 'user@threatwatch.ng'],
            [
                'firstname'         => 'Emeka',
                'surname'           => 'Nwosu',
                'email'             => 'user@threatwatch.ng',
                'password'          => Hash::make('User@12345'),
                'role'              => 'user',
                'phone'             => '+2348123456789',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
    }
}
