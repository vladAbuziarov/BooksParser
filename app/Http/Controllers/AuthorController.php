<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{

    public function __construct(protected readonly AuthorRepositoryInterface $authorRepository)
    {
    }

    public function index(): JsonResponse
    {
        $search  = request()->get('search', '');
        $authors = $this->authorRepository->list($search);

        return response()->json(AuthorResource::collection($authors));
    }

    public function get(Author $author): JsonResponse
    {
        return response()->json([
            'author' => new AuthorResource($author->load('books.authors')),
        ]);
    }
}