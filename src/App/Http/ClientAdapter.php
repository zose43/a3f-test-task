<?php

declare(strict_types = 1);

namespace App\Http;

use App\Enums\Logger;
use Psr\Http\Message\ResponseInterface;

final class ClientAdapter
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function send(string $url): ?ResponseInterface
    {
        return $this->validateUrl($url)
            ? $this->client->send($url)
            : null;
    }

    private function validateUrl(string $url): bool
    {
        $check = preg_match('#^https?://#', $url);
        if (!$check) {
            logger(Logger::Error, "Invalid scheme $url");
        }
        return (bool)$check;
    }
}
