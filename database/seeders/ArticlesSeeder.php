<?php

namespace Database\Seeders;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();

        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            Article::create([
                'title' => $faker->sentence,
                'slug' => $faker->slug,
                'body' => $faker->paragraph
            ]);
        }
    }
}
