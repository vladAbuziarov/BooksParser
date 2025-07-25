<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Book
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property null|string $short_description
 * @property null|string $long_description
 * @property null|int $page_count
 * @property Carbon|null $published_at
 * @property string|null $thumbnail_url
 * @property null|string $status
 * @property-read Collection|Author[] $authors
 * @property-read Collection|Category[] $categories
 */
class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'short_description',
        'long_description',
        'page_count',
        'published_at',
        'thumbnail_url',
        'status'
    ];
    protected $casts    = ['published_at' => 'date'];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_book', 'book_id', 'category_id');
    }
}