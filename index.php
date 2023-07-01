<?php

declare(strict_types = 1);

use App\HtmlCrawler;
use App\Enums\Logger;
use App\Http\ClientAdapter;
use function App\parse;

require __DIR__ . '/vendor/autoload.php';

$url = $argv[1] ?? null;
if (empty($url) || !is_string($url)) {
    logger(Logger::Error, 'Invalid argument url');
    exit(1);
}

$client = new ClientAdapter();
$response = $client->send($url);
$crawler = new HtmlCrawler();

parse($response, $crawler, $url);
