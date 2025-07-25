<?php

namespace App\DTO;

readonly class BookDTO
{

    public function __construct(
        public string $title,
        public array $authors = [],
        public BookIsbn $isbn,
        public ?\DateTime $publishedAt = new \DateTime(),
        public ?string $shortDescription = null,
        public ?string $longDescription = null,
        public ?int $pageCount = null,
        public ?string $thumbnailUrl = null,
        public ?string $status = null,
        public ?array $categories = [],
    )
    {
    }

    public function toArray(): array
    {
        return [
            'title'             => $this->title,
            'authors'           => $this->authors,
            'isbn'              => $this->isbn->value(),
            'published_at'      => $this->publishedAt?->format('Y-m-d'),
            'short_description' => $this->shortDescription,
            'long_description'  => $this->longDescription,
            'page_count'        => $this->pageCount,
            'thumbnail_url'     => $this->thumbnailUrl,
            'status'            => $this->status,
            'categories'        => $this->categories,
        ];
    }

}