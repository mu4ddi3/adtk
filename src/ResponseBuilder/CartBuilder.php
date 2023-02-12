<?php

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

class CartBuilder
{
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products'    => [],
        ];

        foreach ($cart->getProducts() as $cartProduct) {
            $data['products'][] = [
                'id'    => $cartProduct->getProductId(),
                'name'  => $cartProduct->getProductName(),
                'price' => $cartProduct->getProductPrice(),
            ];
        }

        return $data;
    }
}
