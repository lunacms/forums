<?php

namespace Lunacms\Forums\Http\Posts\Controllers;

use Illuminate\Http\Request;
use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Http\Posts\Requests\PostStoreRequest;
use Lunacms\Forums\Http\Posts\Requests\PostUpdateRequest;
use Lunacms\Forums\Http\Posts\Resources\PostResource;
use Lunacms\Forums\Posts\Models\Post;

class PostController extends Controller
{
    /**
     * PostController Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            config('forums.routes.auth_middleware', 'auth')
        )->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // todo: add filtering
        $posts = Post::with([
           'owner',
           'tags',
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
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $post = new Post();
        $post->fill($request->only('title', 'body'));
        $post->owner()->associate($request->user());

        $post->save();

        // add tags
        if ($request->has('tags')) {
            $post->addTags($request->tags);
        }

        // load missing relations
        $post->loadMissing([
            'owner',
            'tags',
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Posts\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->loadMissing([
            'owner',
            'tags',
        ]);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Posts\Requests\PostUpdateRequest  $request
     * @param  \Lunacms\Forums\Posts\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->fill($request->only('title', 'body'));
        $post->save();

        // sync tags
        if ($request->has('tags')) {
            $post->syncTags($request->tags);
        }

        // load missing relations
        $post->loadMissing([
            'owner',
            'tags',
        ]);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lunacms\Forums\Posts\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
