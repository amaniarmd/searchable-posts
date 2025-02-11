<?php

namespace Database\Seeders;

use App\Enumerations\Post\NumberEntries;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(NumberEntries::NUMBER_OF_SEEDS->value)->create();
    }
}
