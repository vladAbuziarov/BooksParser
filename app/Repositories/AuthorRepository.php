<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function list(?string $search = null): Collection
    {
        return Author::query()
            ->when($search, function ($q) use ($search) {
                $isNumeric = is_numeric($search);

                // id =
                if ($isNumeric) {
                    $q->where('id', $search);
                }
                $q->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();
    }
}