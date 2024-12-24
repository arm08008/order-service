<?php

namespace App\Command;

use App\Domain\Order\OrderInterface;
use App\Entity\Order;
use App\Repository\Order\OrderRepositoryInterface;

class CreateOrderCommand
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    /**
     * @param array<string,mixed> $payload
     * @param float $price
     * @return OrderInterface
     */
    public function __invoke(array $payload, float $price): OrderInterface
    {
        $amount = $payload['qty'] * $price;
        $order = new Order();
        $order->setProductId($payload['product']);
        $order->setQuantity($payload['qty']);
        $order->setAmount($amount);

        $this->orderRepository->save($order, true);
        return  $order;
    }
}