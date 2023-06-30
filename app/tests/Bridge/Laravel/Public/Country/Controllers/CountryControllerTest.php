<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel\Public\Country\Controllers;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class CountryControllerTest extends TestCase
{
    private const API_BASE_PATH = '/api/public/countries';

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class=CountrySeeder');
    }

    /**
     * @test
     */
    public function it_gets_countries_response(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH);
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json->has('1')
                    ->first(
                        static fn (AssertableJson $json) => $json
                            ->where('id', 'AD')
                            ->has('id')
                            ->has('name')
                            ->has('emoji')
                            ->has('code')
                            ->has('states')
                            ->etc()
                    )
            );
    }

    /**
     * @test
     */
    public function it_gets_single_country(): void
    {
        $response = $this->json('GET', self::API_BASE_PATH . '/US');
        $response
            ->assertJson(
                static fn (AssertableJson $json) => $json
                    ->where('id', 'US')
                    ->has('id')
                    ->has('name')
                    ->has('emoji')
                    ->has('code')
                    ->has('states', 66)
                    ->etc()
            );
    }
}
