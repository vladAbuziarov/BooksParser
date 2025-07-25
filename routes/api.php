<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('books', [BooksController::class, 'index'])->name('v1.books.index');
    Route::get('authors', [AuthorController::class, 'index'])->name('v1.authors.index');
    Route::get('authors/{author}', [AuthorController::class, 'get'])->name('v1.authors.get');
});