<?php

declare(strict_types = 1);

namespace App;

final class HtmlCrawler implements Crawler
{
    public const EXCLUDE = '!';

    public function tokenize(string $page): array
    {
        // ignore DOCTYPE tag and comments
        preg_match_all(
            '#<(?!/)(?<tag>.*?)(\s|>)#us',
            $page,
            $tokens);

        if (!empty($tokens['tag'])) {
            return array_filter($tokens['tag'],
                static fn(string $t) => $t && !str_contains(
                        $t,
                        self::EXCLUDE));
        }
        return [];
    }

    public function handleTokens(array $tokens): array
    {
        // return sorted set by count desc
        $sortedSet = [];
        foreach ($tokens as $token) {
            if (!isset($sortedSet[$token])) {
                $sortedSet[$token] = 1;
            } else {
                ++$sortedSet[$token];
            }
        }
        arsort($sortedSet);

        return $sortedSet;
    }
}
