<?php

namespace App\Services;

interface BookParserInterface
{
    /**
     * @param string $url
     * @return void
     */
    public function parseResource(string $url): void;
}