<?php

namespace App\Services;

use App\DTO\BookDTO;
use App\DTO\BookIsbn;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Facades\Log;

class BookParser implements BookParserInterface
{
    private const OPERATION = 'book_parser';

    public function __construct(
        protected readonly BookRepositoryInterface $bookRepository,
        protected readonly \GuzzleHttp\Client $client,
        private readonly int $delay = 5
    )
    {
    }

    public function parseResource(string $url): void
    {
        try {
            $books = $this->fetchJson($url);
            foreach ($books as $item) {
                try {
                    $this->bookRepository->upsert($this->map($item));
                    Log::info('Book parsed successfully', [
                        'book_data' => $item,
                        'url'       => $url,
                        'operation' => self::OPERATION,
                    ]);
                    sleep($this->delay);
                } catch (\Throwable $e) {
                    Log::warning('Failed to parse a book', [
                        'error'     => $e->getMessage(),
                        'book_data' => $item,
                        'url'       => $url,
                        'operation' => self::OPERATION,
                    ]);
                    continue;
                }
            }
        } catch (\Throwable $e) {
            throw new $e;
        }

    }
    private function fetchJson(string $url): array
    {
        $response = $this->client->get($url);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to fetch JSON from URL: ' . $url);
        }
        return json_decode($response->getBody()->getContents(), true);
    }
    private function map(array $row): BookDTO
    {
        return new BookDTO(
            title: $row['title'],
            authors: $row['authors'] ?? [],
            isbn: new BookIsbn($row['isbn']),
            publishedAt: isset($row['publishedDate']['$date']) ? new \DateTime($row['publishedDate']['$date']) : null,
            shortDescription: $row['shortDescription'] ?? null,
            longDescription: $row['longDescription'] ?? null,
            pageCount: $row['pageCount'] ?? null,
            thumbnailUrl: $row['thumbnailUrl'] ?? null,
            status: $row['status'] ?? 'PUBLISH',
            categories: $row['categories'] ?? [],
        );
    }
}