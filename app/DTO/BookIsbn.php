<?php

namespace App\DTO;

readonly class BookIsbn
{

    private string $isbn;
    public function __construct(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function value(): string
    {
        return $this->isbn;
    }
}