<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Super Admin
        \App\Models\User::updateOrCreate(
            ['pseudo' => 'tech-memes'],
            [
                'email' => 'cyrushessou@gmail.com',
                'password' => 'admin@123',
                'role' => 'sadmin',
                'statut' => 1
            ]
        );

        // Standard Admins
        \App\Models\User::updateOrCreate(
            ['pseudo' => 'tech-memes-admin'],
            [
                'email' => 'admin@techmemes.com',
                'password' => 'admin@123',
                'role' => 'admin',
                'statut' => 1
            ]
        );

    }
}
