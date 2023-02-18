<?php

namespace Lunacms\Forums\Http\Comments\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Lunacms\Forums\Models\Comment;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given comment can be replied to by the user.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $user
     * @param  \Lunacms\Forums\Models\Comment  $comment
     * @param  \Illuminate\Database\Eloquent\Model|null  $owner
     * @return \Illuminate\Auth\Access\Response
     */    
    public function reply($user, Comment $comment)
    {
        return true;
    }

	/**
	 * Determine if the given comment can be updated by the user.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $user
	 * @param  \Lunacms\Forums\Models\Comment  $comment
	 * @param  \Illuminate\Database\Eloquent\Model|null  $owner
	 * @return \Illuminate\Auth\Access\Response
	 */    
    public function update($user, Comment $comment, $owner = null)
    {
    	$owner = !empty($owner) ? $owner : $user;

        return $this->ownsComment($comment, $owner);
    }

	/**
	 * Determine if the given comment can be updated by the user.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $user
	 * @param  \Lunacms\Forums\Models\Comment  $comment
	 * @param  \Illuminate\Database\Eloquent\Model|null  $owner
	 * @return \Illuminate\Auth\Access\Response
	 */    
    public function destroy($user, Comment $comment, $owner = null)
    {
    	$owner = !empty($owner) ? $owner : $user;

        return $this->ownsComment($comment, $owner);
    }

    /**
     * Determine if user or entity owns a comment.
     * 
     * @param  \Lunacms\Forums\Models\Comment $comment
     * @param  \Illuminate\Database\Eloquent\Model|null  $owner
     * @return \Illuminate\Auth\Access\Response
     */
    public function ownsComment(Comment $comment, $owner = null)
    {
    	return !empty($owner) && $comment->owner->is($owner) ? Response::allow() : Response::deny(
        	__('You do not own this comment.')
        );
    }
}
