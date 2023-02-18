<?php

namespace Lunacms\Forums\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunacms\Forums\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Lunacms\Forums\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
        ];
    }
}
