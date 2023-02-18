<?php

namespace Lunacms\Forums\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Lunacms\Forums\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $model = config('forums.models.users');

        return [
            'title' => $this->faker->words(3, true),
            // 'slug' => $this->faker->unique()->slug(3, true),
            'body' => $this->faker->paragraphs(3, true),
            'forum_id' => Forum::factory()->for($model::factory(), 'forumable'),
        ];
    }
}
