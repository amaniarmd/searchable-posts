<?php

namespace Database\Factories;

use App\Enumerations\Post\NumberEntries;
use App\Enumerations\Post\Fields;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Fields::TITLE->value => $this->faker->sentence(),
            Fields::BODY->value => $this->faker->paragraphs(NumberEntries::NUMBER_OF_BODY_PARAGRAPHS->value, true),
            Fields::CATEGORY_ID->value => Category::factory(),
        ];
    }
}
