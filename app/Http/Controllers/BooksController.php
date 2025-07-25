<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BooksController extends Controller
{

    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
    )
    {
    }

    public function index(): JsonResponse
    {
        $search = request()->get('search', '');
        $books  = $this->bookRepository->list($search);

        return response()->json(BookResource::collection($books));
    }
}