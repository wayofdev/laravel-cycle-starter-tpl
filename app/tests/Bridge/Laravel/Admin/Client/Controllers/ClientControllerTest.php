<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Admin\Client\Controllers;

use Database\Factories\Domain\ClientFactory;
use Domain\Client\Client;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use Tests\Bridge\Laravel\ApiTestCase;

use function count;

final class ClientControllerTest extends ApiTestCase
{
    private const API_BASE_PATH = '/api/admin/clients';

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
    public function it_gets_clients_response(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH);

        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json->has('1')
                    ->first(
                        static fn (AssertableJson $json) => $json
                            ->where('incrementalId', 1)
                            ->has('id')
                            ->has('email')
                            ->has('username')
                            ->has('firstName')
                            ->has('lastName')
                            ->has('company')
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

        $this::assertEquals(3, count($response->json()));
    }

    /**
     * @test
     */
    public function it_gets_single_client(): void
    {
        /** @var Client $client */
        $client = ClientFactory::new()->createOne();

        $response = $this->json('GET', self::API_BASE_PATH . '/' . $client->id()->toString());
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', $client->id()->toString())
                    ->etc()
            );
    }
}
