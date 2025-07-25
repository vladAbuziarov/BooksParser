<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    /**
     * @param string|null $search
     * @return Collection|Author[]
     */
    public function list(?string $search = null): Collection;
}