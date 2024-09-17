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
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'phone' => '000',
            'JMBG' => '000',
            'email' => 'admin@gmail.com',
            'role' => 'ADMIN',
            'approve_status' => 'APPROVED'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'approve_status' => 'APPROVED'
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'moderator',
            'username' => 'moderator',
            'email' => 'moderator@gmail.com',
            'role' => 'MODERATOR',
            'approve_status' => 'APPROVED'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'moderator2',
            'username' => 'moderator2',
            'email' => 'moderator2@gmail.com',
            'role' => 'MODERATOR',
            'approve_status' => 'APPROVED'
        ]);
    }
}