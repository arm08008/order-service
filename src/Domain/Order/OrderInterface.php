<?php

namespace App\Domain\Order;

interface OrderInterface
{
    public function getId(): ?string;

    public function setId(string $id): static;

    public function getQuantity(): ?int;

    public function setQuantity(int $quantity): static;

    public function getAmount(): ?string;

    public function setAmount(string $amount): static;

    public function getProductId(): ?string;

    public function setProductId(string $product_id): static;
}