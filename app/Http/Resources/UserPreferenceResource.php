<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPreferenceResource extends JsonResource
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
            'favorite_sources' => $this->favorite_sources,
            'favorite_categories' => $this->favorite_categories,
            'favorite_authors' => $this->favorite_authors,
        ];
    }
}
