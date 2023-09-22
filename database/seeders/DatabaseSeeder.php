<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(3)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'A',
        //     'email' => 'a@gmail.com',
        //     'phone' => '09374857224',
        // ]);

        \App\Models\User::create([
            'name' => 'A',
            'email' => 'a@gmail.com',
            'phone' => '09374857224',
            'password' => 'password', // password
        ]);

        User::create([
            'name' => 'B',
            'email' => 'b@gmail.com',
            'phone' => '09827636284',
            'password' => 'password', // password
        ]);

        User::create([
            'name' => 'C',
            'email' => 'c@gmail.com',
            'phone' => '09928736453',
            'password' => 'password', // password
        ]);

        Post::factory(10)->create();
    }
}
