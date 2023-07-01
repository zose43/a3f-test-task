<?php

namespace App;

use Exception;
use App\Enums\Logger;
use Psr\Http\Message\ResponseInterface;

function parse(
    ?ResponseInterface $response,
    Crawler            $crawler,
    string             $url
): never
{
    $content = $response?->getBody()->getContents();
    if ($content === '' || $response?->getStatusCode() !== 200) {
        logger(Logger::Info, 'Empty response');
        exit(1);
    }

    try {
        $tokens = $crawler->tokenize($content);
        $result = $crawler->handleTokens($tokens);

        $host = parse_url($url, PHP_URL_HOST);
        file_put_contents(
            $_SERVER['DATA_OUTPUT'] . "/$host.txt",
            json_encode($result, JSON_THROW_ON_ERROR)
        );

        logger(Logger::Info, "Successfully parse $url");
    } catch (Exception $e) {
        logger(Logger::Error, 'Can\'t parse HTML doc', $e);
    } finally {
        exit(0);
    }
}
