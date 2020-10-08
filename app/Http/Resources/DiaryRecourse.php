<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiaryRecourse extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => 'Created at '.date('d M Y', strtotime($this->created_at)). ', '.$this->created_at->diffForHumans(),
            'updated_at' => 'Last updated '.date('d M Y', strtotime($this->updated_at)). ', '.$this->updated_at->diffForHumans(),
        ];
    }
}
