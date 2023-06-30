<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Admin\Network\Controllers;

use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use Tests\Bridge\Laravel\ApiTestCase;

final class NetworkControllerTest extends ApiTestCase
{
    private const API_BASE_PATH = '/api/admin/network';

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
    public function it_should_get_network_response(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH);

        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('response', 'PONG')
                    ->etc()
            );
    }
}
