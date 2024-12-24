<?php

namespace App\Services\ProductServiceApi\Api;

use App\Services\ProductServiceApi\ProductServiceApiClient;

class ProductApi
{
    public function __construct(
        protected ProductServiceApiClient $client
    )
    {
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function listProducts(): array
    {
        return $this->client->list('products');
    }

    /**
     * @param string $productId
     * @param int $qty
     * @return array
     * @throws \Throwable
     */
    public function updateProduct(string $productId, int $qty): array
    {
        return $this->client->patch('product/' . $productId, ['orderQty' => $qty]);
    }
}