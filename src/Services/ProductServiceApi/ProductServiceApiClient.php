<?php

namespace App\Services\ProductServiceApi;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductServiceApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $baseUri,
    )
    {
    }

    public function list(string $endpoint): array
    {
        $uri = $this->baseUri . $endpoint;

        try {
            $response = $this->client->request(Request::METHOD_GET, $uri);

            return $response->toArray();
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }


    public function patch(string $endpoint, array $data = []): array
    {
        $uri = $this->baseUri . $endpoint;

        try {
            $response = $this->client->request(
                Request::METHOD_PATCH, $uri, [
                    'json' => $data,
            ]);

            return $response->toArray();
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }
}