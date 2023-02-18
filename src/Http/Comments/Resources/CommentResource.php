<?php

namespace Lunacms\Forums\Http\Comments\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Lunacms\Forums\Forums;

class CommentResource extends JsonResource
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
            'body' => $this->body,
            'user' => Forums::resolveResourceClass($this->whenLoaded('owner')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_at' => $this->edited_at,
            'children' => CommentResource::collection($this->whenLoaded('children')),
        ];
    }
}
