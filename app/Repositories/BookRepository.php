<?php

namespace App\Repositories;

use App\DTO\BookDTO;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function upsert(BookDTO $book): Book
    {
        $authors    = $book->authors ?? [];
        $categories = $book->categories ?? [];
        DB::beginTransaction();
        try {
            $book = Book::updateOrCreate(
                ['isbn' => $book->isbn->value()],
                Arr::except($book->toArray(), ['authors', 'categories'])
            );
            if ($authors) {
                $ids = collect($authors)
                    ->map(fn($a) => Author::firstOrCreate(['name' => $a])->id)
                    ->all();
                $book->authors()->sync($ids);
            }
            if ($categories) {
                $ids = collect($categories)
                    ->map(fn($c) => Category::firstOrCreate(['name' => $c])->id)
                    ->all();
                $book->categories()->sync($ids);
            }

            DB::commit();
            return $book;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param string $search
     * @return Collection
     */
    public function list(string $search): Collection
    {
        $query = Book::query()
            ->select('books.*')
            ->with(['authors:id,name'])
            ->leftJoin('author_book as ab', 'ab.book_id', '=', 'books.id')
            ->leftJoin('authors as a', 'a.id', '=', 'ab.author_id')
            ->when($search, function ($q) use ($search) {
                $isNumeric = is_numeric($search);

                $q->where(function ($q) use ($search) {
                    $q->whereFullText(['title', 'short_description', 'long_description'], $search, ['mode' => 'boolean']);
                });
                if ($isNumeric) {
                    $q->orWhere('a.id', $search);
                }
                $q->orWhere('a.name', 'like', "%{$search}%");
            });

        return $query->groupBy('books.id')->get();
    }
}