<?php

namespace App\Domain\Order\Response;

use App\Domain\Order\OrderInterface;

class OrderResponseBuilder
{
    public function __construct()
    {
    }

    public function build(OrderInterface $order, array $product): array
    {
        return [
            'id' => $order->getId(),
            'product' => [
                'id' => $product['id'],
                'name' => $product['name'],
                'qty' => $product['qty'],
                'price' => $product['price'],
            ],
            'qty' => $order->getQuantity(),
            'amount' => $order->getAmount(),
        ];
    }

    public function buildAsArray(array $orders, array $products = []): array
    {
        $data = [];
        foreach ($orders as $order) {
            foreach ($products as $product) {
                if ($order->getProductId() === $product['id']) {
                    $data[] = $this->build($order, $product);
                }
            }
        }

        return $data;
    }
}