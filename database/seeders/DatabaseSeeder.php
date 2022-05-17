<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'name' => 'Test Post 1',
        ]);

        Post::create([
            'name' => 'Test Post 2',
        ]);

        Post::create([
            'name' => 'Test Post 3',
        ]);

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


        $user = User::find(1);
        if ($user) {
            $user->posts()->attach([
                1 => ['start_date' => '2022-01-01'],
                2 => ['start_date' => '2022-03-01'],
                3 => ['start_date' => '2022-05-01'],
            ]);
        }

        $user = User::find(2);
        if ($user) {
            $user->posts()->attach([
                1 => ['start_date' => '2022-01-01'],
                2 => ['start_date' => '2022-05-01'],
            ]);
        }

        $user = User::find(3);
        if ($user) {
            $user->posts()->attach([
                1 => ['start_date' => '2022-05-01'],
            ]);
        }
    }
}
