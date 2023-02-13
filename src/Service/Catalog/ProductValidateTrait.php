<?php

namespace App\Service\Catalog;

trait ProductValidateTrait
{
    public function productDataIsValid(string $name, string $price): bool
    {
        $name = trim($name);
        $price = (int)$price;

        return !($name === '' || $price < 1);
    }

}
