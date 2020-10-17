<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'level' => $this->level,
            'created_at' => date('d M Y', strtotime($this->created_at)),
            'created_when' => $this->created_at->diffForHumans(),
            'diaries_count' => $this->diaries_count,
        ];
    }
}
