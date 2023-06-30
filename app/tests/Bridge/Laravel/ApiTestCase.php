<?php

declare(strict_types=1);

namespace Tests\Bridge\Laravel;

use Database\Seeders\ClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use JsonException;
use Tests\TestCase;
use WayOfDev\Auth\Contracts\Authenticatable;
use WayOfDev\Auth\Providers\Oidc\UserFactory;

use function base64_encode;
use function json_encode;

abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    protected UserFactory $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory(['Bearer']);

        Artisan::call('cycle:migrate:fresh', ['--force' => true]);
        Artisan::call('cycle:orm:sync');
        Artisan::call('db:seed');
        // Artisan::call('db:seed', ['--class' => ClientSeeder::class]);
    }

    /**
     * @throws JsonException
     */
    protected function createUser(): Authenticatable
    {
        $attributes = [
            'sub' => '86a0676e-2c15-4221-a797-f3af51d50cb5',
            'realm_access' => [
                'roles' => ['offline_access', 'uma_authorization'],
            ],
            'scope' => 'email profile',
            'preferred_username' => 'service-account-kong',
            'clientId' => 'kong',
            'clientHost' => '172.100.61.1',
            'clientAddress' => '172.100.61.1',
            'groups' => ['editor', 'manager'],
            'given_name' => 'King of the',
            'family_name' => 'World',
            'iss' => 'https://auth.wayofdev.io/auth/realms/services',
            'azp' => 'web',
        ];
        $identifier = base64_encode(json_encode($attributes, JSON_THROW_ON_ERROR | 0, JSON_THROW_ON_ERROR));

        return $this->userFactory->createUser($identifier);
    }
}
