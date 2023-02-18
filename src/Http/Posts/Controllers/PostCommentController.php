<?php

namespace Lunacms\Forums\Http\Posts\Controllers;

use Illuminate\Http\Request;
use Lunacms\Forums\Http\Comments\Requests\CommentStoreRequest;
use Lunacms\Forums\Http\Comments\Resources\CommentResource;
use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Models\Comment;
use Lunacms\Forums\Models\Post;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Lunacms\Forums\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with(['owner', 'children.children'])->paginate();

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Comments\Requests\CommentStoreRequest  $request
     * @param  \Lunacms\Forums\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreRequest $request, Post $post)
    {
        $comment = new Comment();
        $comment->fill($request->only('body'));
        $comment->owner()->associate($request->user());

        $comment = $post->comments()->save($comment);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Models\Post  $post
     * @param  \Lunacms\Forums\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        //
    }
}
