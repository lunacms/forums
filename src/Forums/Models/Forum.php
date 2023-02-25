<?php

namespace Lunacms\Forums\Forums\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Database\Factories\ForumFactory;
use Lunacms\Forums\Models\Traits\HasTagsTrait;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tags\Models\Tag;

class Forum extends Model
{
    use HasFactory, Sluggable, SoftDeletes, HasTagsTrait;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'forums';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
    	'name',
        'slug',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ForumFactory::new();
    }   

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the owning forumable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function forumable()
    {
        return $this->morphTo();
    }

    /**
     * Get all forum comments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get posts owned by forum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the tags for the forum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
