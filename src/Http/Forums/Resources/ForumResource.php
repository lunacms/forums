<?php

namespace Lunacms\Forums\Http\Forums\Resources;

use Lunacms\Forums\Http\Tags\Resources\TagResource;
use Lunacms\Forums\Http\Posts\Resources\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Lunacms\Forums\Forums;

class ForumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => optional($this->created_at)->diffForHumans(),
            'posts_count' => $this->posts_count,
            'owner' => Forums::resolveResourceClass($this->whenLoaded('forumable')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
