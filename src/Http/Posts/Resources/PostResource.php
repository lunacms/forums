<?php

namespace Lunacms\Forums\Http\Posts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Lunacms\Forums\Forums;
use Lunacms\Forums\Http\Comments\Resources\CommentResource;
use Lunacms\Forums\Http\Forums\Resources\ForumResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $comments = $this->whenLoaded('comments');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'comments_count' => $this->comments_count,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'owner' => Forums::resolveResourceClass($this->whenLoaded('owner')),
            'forum' => new ForumResource($this->whenLoaded('forum')),
            'comments' => $comments instanceof MissingValue ? $comments : CommentResource::collection(
                $comments
            ),
        ];
    }
}
