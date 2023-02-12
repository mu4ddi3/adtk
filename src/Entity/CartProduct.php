<?php

namespace App\Entity;

use App\Service\Catalog\Product;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'cart_products')]
class CartProduct implements \App\Service\Cart\CartProduct
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: 'Cart', inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: 'Product')]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    public function __construct(Cart $cart, Product $product, ?string $id = null)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->id = $id ? Uuid::fromString($id) : Uuid::uuid4();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getProductName(): string
    {
        return $this->getProduct()->getName();
    }

    public function getProductPrice(): int
    {
        return $this->getProduct()->getPrice();
    }

    public function getProductId(): string
    {
        return $this->getProduct()->getId();
    }
}
