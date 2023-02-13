<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Tests\Functional\WebTestCase;

class UpdateControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new UpdateControllerFixture());
    }

    public function test_updates_product(): void
    {
        $this->client->request('PUT', '/products/' . UpdateControllerFixture::PRODUCT_ID, [
            'name'  => 'Product with updated name',
            'price' => 2023,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product with updated name', $response['products'][0]['name']);
        self::assertequals(2023, $response['products'][0]['price']);
    }

    public function test_shows_error_when_invalid_data_was_provided_and_skip_updating(): void
    {
        $this->client->request('PUT', '/products/' . UpdateControllerFixture::PRODUCT_ID, [
            'name'  => '',
            'price' => 0,
        ]);

        self::assertResponseStatusCodeSame(422);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product to be updated', $response['products'][0]['name']);
        self::assertequals(2022, $response['products'][0]['price']);
    }

}
