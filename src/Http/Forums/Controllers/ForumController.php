<?php

namespace Lunacms\Forums\Http\Forums\Controllers;

use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Http\Forums\Requests\ForumStoreRequest;
use Lunacms\Forums\Http\Forums\Requests\ForumUpdateRequest;
use Lunacms\Forums\Http\Forums\Resources\ForumResource;

class ForumController extends Controller
{
    /**
     * ForumController Constructor.
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forums = Forum::with('forumable', 'tags')
            ->withCount(['posts'])
            ->latest('created_at')
            ->get();

        return ForumResource::collection($forums);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Lunacms\Forums\Http\Requests\ForumStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForumStoreRequest $request)
    {
        $forum = new Forum();
        $forum->fill($request->only('name'));
        $forum->forumable()->associate($request->user());

        $forum->save();

        $forum->addTags($request->tags);

        return new ForumResource($forum);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Forums\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        $forum->loadMissing([
            'tags',
            'forumable'
        ]);

        return new ForumResource($forum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Lunacms\Forums\Http\Requests\ForumUpdateRequest  $request
     * @param  \Lunacms\Forums\Forums\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(ForumUpdateRequest $request, Forum $forum)
    {
        $forum->fill($request->only('name'));
        $forum->forumable()->associate($request->user());

        $forum->save();

        $forum->syncTags($request->tags);

        return new ForumResource($forum);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lunacms\Forums\Forums\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();

        return response()->noContent();
    }
}
