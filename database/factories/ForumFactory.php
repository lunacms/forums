<?php

namespace Lunacms\Forums\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunacms\Forums\Forums\Models\Forum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Lunacms\Forums\Forums\Models\Forum>
 */
class ForumFactory extends Factory
{
    protected $model = Forum::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            // 'slug' => $this->faker->unique()->slug,
        ];
    }
}
