<?php

namespace App\Service\Cart;

interface CartProduct
{
    public function getProductId(): string;
    public function getProductName(): string;
    public function getProductPrice(): int;
}
