<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'author' => $this->author,
            'source_url' => $this->source_url,
            'thumbnail_url' => $this->thumbnail_url,
            'published_at' => date('D M j, Y', strtotime($this->published_at)),
            'category' => $this->category->name,
            'source' => $this->news_source->name,
        ];
    }
}
