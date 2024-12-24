<?php

namespace App\Repository\Order;

use App\Domain\Order\OrderInterface;

interface OrderRepositoryInterface
{
    public function save(OrderInterface $entity, bool $flush = false): void;

    public function remove(OrderInterface $entity, bool $flush = false): void;
}