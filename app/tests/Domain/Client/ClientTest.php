<?php

declare(strict_types=1);

namespace Tests\Domain\Client;

use Cycle\ORM\ORM;
use Database\Factories\Domain\ClientFactory;
use Domain\Client\Client;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Throwable;
use WayOfDev\Cycle\Repository;

final class ClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     *
     * @throws Throwable
     */
    public function it_creates_client_entity_object(): void
    {
        /** @var ORM $entityManager */
        $entityManager = app(ORM::class);

        /** @var Repository $clientRepository */
        $clientRepository = $entityManager->getRepository(Client::class);

        /** @var Collection $users */
        $users = ClientFactory::new()->times(1)->make();

        $users->each(function (Client $user) use ($clientRepository): void {
            $clientRepository->persist($user, false);
        });

        $this->assertDatabaseCount('clients', 1);
    }
}
