<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateProductInCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private ProductService $service) { }

    public function __invoke(UpdateProductInCatalog $command): void
    {
        $this->service->update($command->productId, $command->name, $command->price);
    }
}
