<?php

namespace Lunacms\Forums\Tags\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lunacms\Forums\Database\Factories\TagFactory;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;

class Tag extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'forum_tags';

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
     * Generate model's slugs.
     * 
     * @return array
     */
    public function sluggable(): array
    {
    	return [
    		'slug' => [
    			'source' => ['name'],
    		],
    	];
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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TagFactory::new();
    }   

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Get all of the forums that are assigned this tag.
     */
    public function forums()
    {
        return $this->morphedByMany(Forum::class, 'taggable');
    }
}
