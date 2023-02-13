<?php

namespace App\Service\Catalog;

use DateTimeImmutable;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;

    public function getCreatedAt(): ?DateTimeImmutable;
}
