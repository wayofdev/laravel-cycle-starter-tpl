<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Admin\Order\Controllers;

use Database\Factories\Domain\OrderFactory;
use Domain\Order\Order;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Bridge\Laravel\ApiTestCase;

final class OrderControllerTest extends ApiTestCase
{
    private const API_BASE_PATH = '/api/admin/orders';

    /**
     * @throws JsonException
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = $this->createUser();
        $this->actingAs($user, 'api');
    }

    /**
     * @test
     */
    public function it_gets_orders_response(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH);

        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json->has('1')
                    ->first(
                        static fn (AssertableJson $json) => $json
                            ->where('incrementalId', 1)
                            ->has('id')
                            ->etc()
                    )
            );
    }

    /**
     * @test
     */
    public function it_supports_pagination(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH . '?page=1&per_page=3');

        $this::assertCount(3, $response->json());
    }

    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_gets_single_order(): void
    {
        /** @var Order $order */
        $order = OrderFactory::new()->createOne();

        $response = $this->json('GET', self::API_BASE_PATH . '/' . $order->id()->toString());
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', $order->id()->toString())
                    ->etc()
            );
    }
}
