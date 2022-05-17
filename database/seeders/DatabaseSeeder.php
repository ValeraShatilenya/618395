<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
        ]);

        User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
        ]);

        User::create([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
        ]);
    }
}
