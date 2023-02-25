<?php

namespace Lunacms\Forums\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunacms\Forums\Tags\Models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Lunacms\Forums\Tags\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug
        ];
    }
}
