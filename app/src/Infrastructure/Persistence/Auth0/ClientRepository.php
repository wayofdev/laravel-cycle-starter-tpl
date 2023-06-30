<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Auth0;

use Auth0\Laravel\UserRepositoryAbstract;
use Auth0\Laravel\UserRepositoryContract;
use Auth0\Laravel\Users\StatefulUser;
use Auth0\Laravel\Users\StatelessUser;
use Domain\Client\ClientRepository as CycleClientRepository;
use Illuminate\Contracts\Auth\Authenticatable;

final class ClientRepository extends UserRepositoryAbstract implements UserRepositoryContract
{
    public function __construct(
        private readonly CycleClientRepository $clientRepository
    ) {
    }

    public function fromAccessToken(array $user): ?Authenticatable
    {
        dd($user);

        $client = $this->clientRepository->findOne([
            'auth0_id' => $user['email'],
        ]);

        if (! $client) {
            return null;
        }

        $client->token($user);

        dd($user);

        return $client;

        return new StatelessUser($user);
    }

    public function fromSession(array $user): ?Authenticatable
    {
        return new StatefulUser($user);
    }
}
