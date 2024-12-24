<?php

namespace App\Query;

use App\Repository\Order\OrderRepositoryInterface;

class GetOrdersListQuery
{
    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
    ) {
    }


    /**
     * @return array
     */
    public function __invoke(): array
    {
        return $this->orderRepository->findAll();
    }
}