<?php

namespace Lunacms\Forums\Http\Comments\Controllers;

use Illuminate\Http\Request;
use Lunacms\Forums\Http\Comments\Resources\CommentResource;
use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Comments\Models\Comment;

class CommentReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \Lunacms\Forums\Comments\Models\Comment $comment
     * @return \Lunacms\Forums\Http\Comments\Resources\CommentResource
     */
    public function __invoke(Request $request, Comment $comment)
    {
        $this->authorize('reply', $comment);

        $this->validate($request, [
            'body' => 'required|max:5000'
        ]);

        $reply = new Comment();
        $reply->fill($request->only('body'));

        $reply->commentable()->associate($comment->commentable);
        $reply->parent()->associate($comment);

        $request->user()->comments()->save($reply);

        return new CommentResource($reply);
    }
}
