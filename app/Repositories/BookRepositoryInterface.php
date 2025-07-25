<?php

namespace App\Repositories;

use App\DTO\BookDTO;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    /**
     * @param BookDTO $book
     * @return Book
     */
    public function upsert(BookDTO $book) : Book;

    /**
     * @param string $search
     * @return Collection|Book[]
     */
    public function list(string $search): Collection;
}