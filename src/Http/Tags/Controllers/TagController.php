<?php

namespace Lunacms\Forums\Http\Tags\Controllers;

use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Http\Tags\Requests\TagStoreRequest;
use Lunacms\Forums\Http\Tags\Requests\TagUpdateRequest;
use Lunacms\Forums\Http\Tags\Resources\TagResource;
use Lunacms\Forums\Tags\Models\Tag;

class TagController extends Controller
{
    /**
     * TagController Constructor.
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
        $tags = Tag::latest('created_at')->paginate();

        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Tags\Requests\TagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $tag = new Tag();
        $tag->fill($request->only('name'));

        $tag->save();

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Tags\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Tags\Requests\TagUpdateRequest  $request
     * @param  \Lunacms\Forums\Tags\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag->fill($request->only('name'));
        $tag->save();

        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lunacms\Forums\Tags\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->noContent();
    }
}
