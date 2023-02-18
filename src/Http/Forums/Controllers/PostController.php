<?php

namespace Lunacms\Forums\Http\Forums\Controllers;

use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Models\Post;
use Illuminate\Http\Request;
use Lunacms\Forums\Http\Posts\Requests\PostStoreRequest;
use Lunacms\Forums\Http\Posts\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Lunacms\Forums\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function index(Forum $forum)
    {
        $posts = $forum->posts()->with([
           'owner',
        ])->withCount([
            'comments',
        ])
        ->latest('created_at')
        ->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Posts\Requests\PostStoreRequest  $request
     * @param  \Lunacms\Forums\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request, Forum $forum)
    {
        $post = new Post();
        $post->fill($request->only('title', 'body'));
        $post->owner()->associate($request->user());

        $post = $forum->posts()->save($post);

        // todo: tags
        // $post->addTags($request->tags);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Models\Forum  $forum
     * @param  \Lunacms\Forums\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum, Post $post)
    {
        $post->loadMissing([
            'owner',
        ]);

        return new PostResource($post);
    }
}
