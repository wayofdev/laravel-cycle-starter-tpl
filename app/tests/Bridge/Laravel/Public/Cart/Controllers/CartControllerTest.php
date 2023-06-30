<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Public\Cart\Controllers;

use Database\Factories\Domain\CartFactory;
use Domain\Cart\Cart;
use Illuminate\Testing\Fluent\AssertableJson;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;
use WayOfDev\Serializer\HttpCode;

final class CartControllerTest extends TestCase
{
    private const API_BASE_PATH = '/api/public/carts';

    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_gets_existing_cart(): void
    {
        /** @var Cart $cart */
        $cart = CartFactory::new()->createOne();

        $response = $this->json('GET', self::API_BASE_PATH . '/' . $cart->id()->toString());
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', $cart->id()->toString())
                    ->etc()
            );
    }

    /**
     * @test
     */
    public function it_creates_new_cart(): void
    {
        $response = $this->json('POST', self::API_BASE_PATH, []);

        $response
            ->assertStatus(HttpCode::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'incrementalId',
                'created',
                'updated',
            ]);

        $this->assertDatabaseHas('carts', [
            'id' => $response->json('id'),
        ]);
    }
}
