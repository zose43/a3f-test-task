<?php

declare(strict_types = 1);

namespace App;

interface Crawler
{
    public function tokenize(string $page): array;

    public function handleTokens(array $tokens): array;
}
