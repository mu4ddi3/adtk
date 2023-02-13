<?php

namespace App\Controller\Catalog;

use App\Messenger\AddProductToCatalog;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use App\Service\Catalog\ProductValidateTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"POST"}, name="product-add")
 */
class AddController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;
    use ProductValidateTrait;

    public function __construct(private ErrorBuilder $errorBuilder) { }

    public function __invoke(Request $request): Response
    {
        $name  = trim($request->get('name'));
        $price = (int)$request->get('price');

        if (!$this->productDataIsValid($name, $price)) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new AddProductToCatalog($name, $price));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
