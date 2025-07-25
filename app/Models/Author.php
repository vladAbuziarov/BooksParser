<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Author
 *
 * @property int $id
 * @property string $name
 * @property Collection|Book[] $books
 */
class Author extends Model
{
    protected $fillable = ['name'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}