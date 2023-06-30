<?php

declare(strict_types=1);

namespace Laravel\Public\Cart\Controllers;

use Application\Cart\Commands\StoreCart;
use Application\Cart\Commands\ViewCart;
use Application\Cart\Dto\StoreCartDto;
use Application\Cart\Dto\ViewCartDto;
use Application\Cart\Services\StoreCartService;
use Application\Cart\Services\ViewCartService;
use Domain\Cart\Cart;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use Laravel\Public\Cart\Requests\StoreFormRequest;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use Throwable;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'carts',
    only: ['show', 'store'],
    names: 'api.public.carts',
    shallow: true
)]
final class CartController extends ApiController
{
    #[OAT\Get(
        path: '/api/public/carts/{cart_id}',
        description: 'This endpoint returns a single cart.',
        summary: 'Get single cart.',
        tags: ['carts'],
        parameters: [
            new OAT\Parameter(
                name: 'cart_id',
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
                schema: new OAT\Schema(ref: ViewCartDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Cart $cart, ViewCartService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewCart($cart))
        );
    }

    /**
     * @throws Throwable
     */
    #[OAT\Post(
        path: '/api/public/carts',
        description: 'This endpoint stores new cart into database storage.',
        summary: 'Store new cart',
        tags: ['carts']
    )]
    #[OAT\RequestBody(
        description: 'Cart data',
        required: true,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: StoreCartDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_CREATED,
        description: HttpStatus::HTTP_CREATED,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: ViewCartDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNPROCESSABLE_ENTITY,
        description: HttpStatus::HTTP_UNPROCESSABLE_ENTITY
    )]
    public function store(?Authenticatable $user, StoreCartService $service, StoreFormRequest $request): Response
    {
        // $dto = $this->serializer->unserialize(
        //     $request->getContent(),
        //     StoreCartDto::class
        // );
        // $command = new StoreCart($dto, $user?->getFootprint());

        $command = new StoreCart($user?->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }
}
