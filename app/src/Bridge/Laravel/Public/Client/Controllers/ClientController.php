<?php

declare(strict_types=1);

namespace Laravel\Public\Client\Controllers;

use Application\Client\Commands\ViewClient;
use Application\Client\Services\ViewClientService;
use Domain\Client\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Spatie\RouteAttributes\Attributes\ApiResource;

#[ApiResource(
    resource: 'clients',
    only: ['show', 'update'],
    names: 'api.public.clients',
    shallow: true
)]
class ClientController extends ApiController
{
    public function show(Authenticatable $user, Client $client, ViewClientService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewClient($client))
        );
    }
}
