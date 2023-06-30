<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Public\Category\Controllers;

use Database\Factories\Domain\CategoryFactory;
use Domain\Category\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\Bridge\Laravel\ApiTestCase;

final class CategoryControllerTest extends ApiTestCase
{
    private const API_BASE_PATH = '/api/public/categories';

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
    public function it_gets_categories_response(): void
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
    public function it_gets_single_category(): void
    {
        /** @var Category $category */
        $category = CategoryFactory::new()->createOne();

        $response = $this->json('GET', self::API_BASE_PATH . '/' . $category->id()->toString());
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', $category->id()->toString())
                    ->etc()
            );
    }
}
