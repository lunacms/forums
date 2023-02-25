<?php

namespace Lunacms\Forums\Http\Comments\Controllers;

use Illuminate\Http\Request;
use Lunacms\Forums\Http\Comments\Requests\CommentUpdateRequest;
use Lunacms\Forums\Http\Comments\Resources\CommentResource;
use Lunacms\Forums\Http\Controllers\Controller;
use Lunacms\Forums\Comments\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Lunacms\Forums\Comments\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request|\Lunacms\Forums\Http\Comments\Requests\CommentUpdateRequest  $request
     * @param  \Lunacms\Forums\Comments\Models\Comment  $comment
     * @return \Illuminate\Http\Response|\Lunacms\Forums\Http\Comments\Resources\CommentResource
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->fill($request->only('body'));
        $comment->save();
        
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lunacms\Forums\Comments\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $comment->delete();

        return response()->noContent();
    }
}
