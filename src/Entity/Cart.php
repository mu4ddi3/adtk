<?php

namespace App\Entity;

use App\Service\Catalog\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: 'CartProduct', cascade: ['persist'], orphanRemoval: true)]
    private Collection $cartProducts;

    public function __construct(string $id)
    {
        $this->id           = Uuid::fromString($id);
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce($this->cartProducts->toArray(), static fn(int $total, CartProduct $cartProduct): int => $total + $cartProduct->getProductPrice(), 0);
    }

    #[Pure]
    public function isFull(): bool
    {
        return $this->cartProducts->count() >= self::CAPACITY;
    }

    public function getProducts(): iterable
    {
//        return $this->cartProducts->getIterator();
        return $this->cartProducts;
    }

    #[Pure]
    public function hasProduct(CartProduct $cartProduct): bool
    {
        return $this->cartProducts->contains($cartProduct);
    }

    public function addProduct(CartProduct $cartProduct): void
    {
        $this->cartProducts->add($cartProduct);
    }

    public function removeProduct(CartProduct $cartProduct): void
    {
        $this->cartProducts->removeElement($cartProduct);
    }
}
