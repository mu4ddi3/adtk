<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class CartRepositoryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_check_that_cart_repository_will_not_add_product_to_full_cart_and_persist_the_changes(): void
    {
        $cartId    = '85e99303-dbe1-47ef-b249-25c1ab46f771';
        $productId = '2832fb49-9a9f-4797-9207-88d311c3a9be';
        $cart      = new Cart($cartId);
        $product   = new Product($productId, 'product 1', 8770);

        //fill the cart
        $cart->addProduct(new CartProduct($cart, $product));
        $cart->addProduct(new CartProduct($cart, $product));
        $cart->addProduct(new CartProduct($cart, $product));

        $entityManager = $this->createMock(EntityManager::class);

        $entityManager
            ->expects($this->exactly(2))
            ->method('find')
            ->willReturnOnConsecutiveCalls(
                $cart,
                $product
            );

        $entityManager
            ->expects($this->never())
            ->method('persist');

        $cartRepository = new CartRepository($entityManager);
        $cartRepository->addProduct($cartId, $productId);
    }
}
