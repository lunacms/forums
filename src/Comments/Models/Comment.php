<?php

namespace Lunacms\Forums\Comments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\NodeTrait;
use Lunacms\Forums\Database\Factories\CommentFactory;

class Comment extends Model
{
    use HasFactory, NodeTrait, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'forum_comments';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
    	'body',
    ];

    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'edited_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updating(function ($comment) {
            $comment->edited_at = Carbon::now();
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CommentFactory::new();
    }   

    /**
     * Get the comment's owner.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
    	return $this->morphTo('owner');
    }

    /**
     * Get the owning commentable model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
