<?php

declare(strict_types=1);

namespace Laravel\Public\Client\Controllers;

use Domain\Client\Address\Address;
use Domain\Client\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'clients.addresses',
    only: ['index', 'show', 'store', 'update', 'destroy'],
    names: 'api.public.clients.addresses',
    shallow: false
)]
class AddressController extends ApiController
{
    public function index(Authenticatable $user, Client $client, ListAddressesService $service, QueryFormRequest $request): Response
    {
        /** @var QueryAddressDto $requestQuery */
        $requestQuery = $request->toDto(new QueryAddressDto());

        $collection = $service->handle(
            new ListAddresses($requestQuery),
        );

        return $this->response->fromArray(
            $collection->toArray()
        )->withHeaders($collection->headers());
    }

    public function show(Authenticatable $user, Client $client, Address $address, ViewAddressService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewAddress($address))
        );
    }

    public function store(Authenticatable $user, Client $client, StoreAddressService $service, StoreFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            StoreAddressDto::class
        );
        $command = new StoreAddress($dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }

    public function update(Authenticatable $user, Client $client, Address $address, UpdateAddressService $service, UpdateFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            UpdateAddressDto::class
        );

        $command = new UpdateAddress($address, $dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }
}
