<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Antonio Gabriel',
            'email' => 'antoniogabriel@gmail.com',
            'password' => bcrypt('antoniogabriel'),
        ]);

        $categoriesSeed = [
            ['name' => 'Digital Transformation'],
            ['name' => 'Innovation'],
            ['name' => 'Work & life'],
            ['name' => 'News'],
            ['name' => 'Diversity & Inclusion'],
            ['name' => 'Sustainability']
        ];

        foreach ($categoriesSeed as $category) {
            Category::create($category);
        }
    }
}
