<?php

namespace Lunacms\Forums\Http\Users\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Lunacms\Forums\Http\Forums\Resources\ForumResource;

class UserResource extends JsonResource
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
            'created_at' => $this->created_at->diffForHumans(),
            'forum' => new ForumResource($this->whenLoaded('forum')),
        ];
    }
}
