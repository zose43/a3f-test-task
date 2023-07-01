<?php

declare(strict_types = 1);

namespace App\Http;

use Exception;
use App\Enums\Logger;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client as GuzzleClient;

final class Client
{
    public function send(string $url): ?ResponseInterface
    {
        $client = $this->getClient();
        try {
            return $client->get($url);
        } catch (Exception $e) {
            logger(Logger::Error, 'Can\'t get response', $e);
            return null;
        }
    }

    private function getClient(): GuzzleClient
    {
        return new GuzzleClient([
            'timeout' => 6.0,
            'allow_redirects' => true,
            'verify' => false,
            'headers' => [
                'User-Agent' => $this->getUserAgent()
            ],
        ]);
    }

    private function getUserAgent(): string
    {
        $uAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36'
        ];
        return $uAgents[array_rand($uAgents)];
    }
}
