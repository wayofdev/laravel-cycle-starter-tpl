<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Admin\Product\Controllers;

use Database\Factories\Domain\ProductFactory;
use Domain\Product\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Bridge\Laravel\ApiTestCase;
use WayOfDev\Serializer\HttpCode;

final class ProductControllerTest extends ApiTestCase
{
    private const API_BASE_PATH = '/api/admin/products';

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
    public function it_gets_products_response(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH);

        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json->has('1')
                    ->first(
                        static fn (AssertableJson $json) => $json
                            ->where('incrementalId', 1)
                            ->has('id')
                            ->has('name')
                            ->has('status')
                            ->has('description')
                            ->has('code')
                            ->has('seo')
                            ->has('created')
                            ->has('updated')
                            ->has('deleted')
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
    public function it_gets_single_product(): void
    {
        /** @var Product $product */
        $product = ProductFactory::new()->createOne();

        $response = $this->json('GET', self::API_BASE_PATH . '/' . $product->id()->toString());
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', $product->id()->toString())
                    ->has('incrementalId')
                    ->has('name')
                    ->has('status')
                    ->has('description')
                    ->has('code')
                    ->has('seo')
                    ->has('created')
                    ->has('updated')
                    ->has('deleted')
                    ->etc()
            );
    }

    /**
     * @test
     */
    public function it_stores_product(): void
    {
        /** @var Product $product */
        $product = ProductFactory::new()->makeOne();

        $response = $this->json('POST', self::API_BASE_PATH, [
            'name' => $product->name(),
            'status' => $product->status()->toString(),
            'description' => $product->description(),
            'category' => [
                'id' => $product->category()->id()->toString(),
            ],
            'code' => $product->code()->toArray(),
            'seo' => $product->seo()->toArray(),
        ]);

        $response
            ->assertStatus(HttpCode::HTTP_CREATED)
            ->assertJsonStructure([
                'name',
                'status',
                'description',
                'category',
                'code',
                'seo',
            ]);

        $this->assertDatabaseHas('products', [
            'name' => $product->name(),
            'code_sku' => $product->code()->sku()?->toString(),
        ]);
    }

    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_updates_product(): void
    {
        /** @var Product $product */
        $product = ProductFactory::new()->createOne();
        $name = fake()->name;

        $response = $this->json('PUT', self::API_BASE_PATH . '/' . $product->id(), [
            'name' => $name,
        ]);

        $response
            ->assertStatus(HttpCode::HTTP_CREATED)
            ->assertJsonStructure([
                'name',
                'status',
                'code',
                'description',
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id(),
            'name' => $name,
        ]);
    }

    /**
     * @test
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function it_updates_entity_only_with_provided_data(): void
    {
        /** @var Product $product */
        $product = ProductFactory::new()->createOne();

        $response = $this->json('PUT', self::API_BASE_PATH . '/' . $product->id(), [
            'code' => [
                'sku' => 'new-sku',
                'ian' => 'new-ian',
            ],
            'seo' => [
                'slug' => 'new-slug',
                'title' => 'new-title',
            ],
        ]);

        $response
            ->assertStatus(HttpCode::HTTP_CREATED)
            ->assertJsonPath('code.sku', 'new-sku')
            ->assertJsonPath('code.ian', 'new-ian')
            ->assertJsonPath('code.upc', $product->code()->upc()?->toString())
            ->assertJsonPath('seo.slug', 'new-slug')
            ->assertJsonPath('seo.title', 'new-title')
            ->assertJsonPath('seo.description', $product->seo()->description())
        ;

        $this->assertDatabaseHas('products', [
            'name' => $product->name(),
            'code_sku' => 'new-sku',
            'code_ian' => 'new-ian',
            'code_upc' => $product->code()->upc()?->toString(),
        ]);
    }
}
