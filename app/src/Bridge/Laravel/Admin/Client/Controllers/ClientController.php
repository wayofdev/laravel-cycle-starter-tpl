<?php

declare(strict_types=1);

namespace Laravel\Admin\Client\Controllers;

use Application\Client\Commands\ListClients;
use Application\Client\Commands\ViewClient;
use Application\Client\Dto\QueryClientDto;
use Application\Client\Dto\ViewClientDto;
use Application\Client\Services\ListClientsService;
use Application\Client\Services\ViewClientService;
use Domain\Client\Client;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Http\Response;
use Laravel\Admin\Client\Requests\QueryFormRequest;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'clients',
    only: ['index', 'show'],
    names: 'api.admin.clients',
    shallow: true
)]
final class ClientController extends ApiController
{
    #[OAT\Get(
        path: '/api/admin/clients',
        description: 'This endpoint returns a list of clients in private collection.',
        summary: 'Get list of clients.',
        tags: ['clients'],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(Pagination $pagination, ListClientsService $service, QueryFormRequest $request): Response
    {
        /** @var QueryClientDto $requestQuery */
        $requestQuery = $request->toDto(new QueryClientDto());

        $collection = $service->handle(
            new ListClients($requestQuery),
            $pagination
        );

        return $this->response->fromArray(
            $collection->toArray()
        )->withHeaders($collection->headers());
    }

    #[OAT\Get(
        path: '/api/admin/clients/{client_id}',
        description: 'This endpoint returns a single client.',
        summary: 'Get single client.',
        tags: ['clients'],
        parameters: [
            new OAT\Parameter(
                name: 'client_id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            ),
        ]
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: ViewClientDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Client $client, ViewClientService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewClient($client))
        );
    }
}
