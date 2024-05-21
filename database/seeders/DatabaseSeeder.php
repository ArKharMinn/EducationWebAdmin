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
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '09981559833',
            'address' => 'Mandalay',
            'gender' => 'male',
            'admin_id' => 'Admin' . rand(100000, 999999),
            'password' => 'admin123',
        ]);
    }
}
