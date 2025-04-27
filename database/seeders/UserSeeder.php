<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a specific user
        User::create([
            'username' => 'Admin Test',
            'first_name' => 'First',
            'last_name' => 'Last',
            'email' => 'test@test.test',
            'phone' => '600600600',
            'password' => bcrypt('test'),
            'role' => 'Admin'
        ]);

        // Insert multiple random users
        User::factory()
            ->count(10)
            ->create();
    }
}