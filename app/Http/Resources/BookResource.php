<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'authors'           => AuthorResource::collection($this->whenLoaded('authors')),
            'published_at'      => $this->published_at?->format('Y-m-d'),
            'isbn'              => $this->isbn,
            'short_description' => $this->short_description,
            'long_description'  => $this->long_description,
        ];
    }
}
