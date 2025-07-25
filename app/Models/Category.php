<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property Collection|Book[] $books
 */
class Category extends Model
{
    protected $fillable = ['name'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'category_book', 'category_id', 'book_id');
    }
}