<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class UpdateControllerFixture extends AbstractFixture
{

    public const PRODUCT_ID = '5e90f16d-d2d6-46d3-aed0-7d777462df88';

    public function load(ObjectManager $manager): void
    {
        $product = new Product(self::PRODUCT_ID, 'Product to be updated', 2022);
        $manager->persist($product);
        $manager->flush();
    }
}
