<?php

declare(strict_types=1);

namespace Laravel\Admin\Product\Controllers;

use Application\Product\Commands\ListProducts;
use Application\Product\Commands\StoreProduct;
use Application\Product\Commands\UpdateProduct;
use Application\Product\Commands\ViewProduct;
use Application\Product\Dto\QueryProductDto;
use Application\Product\Dto\StoreProductDto;
use Application\Product\Dto\UpdateProductDto;
use Application\Product\Dto\ViewProductDto;
use Application\Product\Services\ListProductsService;
use Application\Product\Services\StoreProductService;
use Application\Product\Services\UpdateProductService;
use Application\Product\Services\ViewProductService;
use Auth0\Laravel\Facade\Auth0;
use Domain\Product\Product;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Admin\Product\Requests\QueryFormRequest;
use Laravel\Admin\Product\Requests\StoreFormRequest;
use Laravel\Admin\Product\Requests\UpdateFormRequest;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use Throwable;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'products',
    only: ['index', 'show', 'store', 'update'],
    names: 'api.admin.products',
    shallow: true,
)]
class ProductController extends ApiController
{
    #[OAT\Get(
        path: '/api/admin/products',
        description: 'This endpoint returns a list of products in private collection.',
        summary: 'Get list of products.',
        tags: ['products']
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(Pagination $pagination, ListProductsService $service, QueryFormRequest $request): Response
    {
        // dd($user = auth()->user());

        // /** @var \Auth0\Laravel\Service $auth0 */
        // $auth0 = app('auth0');

        // dd($auth0);

        $user = Auth0::management();
        $profile = $user->users()->get(
            auth()->id()
        );

        dd(Auth0::json($profile));

        // $user = $auth0->

        $endpoint = Auth0::management()->users();
        $profile = $endpoint->get(auth()->id());
        $profile = Auth0::json($profile);

        dd($profile);

        /** @var QueryProductDto $requestQuery */
        $requestQuery = $request->toDto(new QueryProductDto());

        $collection = $service->handle(
            new ListProducts($requestQuery),
            $pagination
        );

        return $this->response->fromArray(
            $collection->toArray()
        )->withHeaders($collection->headers());
    }

    #[OAT\Get(
        path: '/api/admin/products/{product_id}',
        description: 'This endpoint returns a single product.',
        summary: 'Get single product.',
        tags: ['products'],
        parameters: [
            new OAT\Parameter(
                name: 'product_id',
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
                schema: new OAT\Schema(ref: ViewProductDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Product $product, ViewProductService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewProduct($product))
        );
    }

    /**
     * @throws Throwable
     */
    #[OAT\Post(
        path: '/api/admin/products',
        description: 'This endpoint stores new product into database storage.',
        summary: 'Store new product',
        tags: ['products']
    )]
    #[OAT\RequestBody(
        description: 'Product data',
        required: true,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: StoreProductDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_CREATED,
        description: HttpStatus::HTTP_CREATED,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: ViewProductDto::class)
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
    public function store(Authenticatable $user, StoreProductService $service, StoreFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            StoreProductDto::class
        );

        $command = new StoreProduct($dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }

    /**
     * @throws Throwable
     */
    #[OAT\Put(
        path: '/api/admin/products/{product_id}',
        description: 'This endpoint updates fields of category.',
        summary: 'Update category contents.',
        tags: ['products'],
        parameters: [
            new OAT\Parameter(
                name: 'product_id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            ),
        ]
    )]
    #[OAT\RequestBody(
        description: 'Product data',
        required: true,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: UpdateProductDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_CREATED,
        description: HttpStatus::HTTP_CREATED,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: ViewProductDto::class)
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
    public function update(Authenticatable $user, Product $product, UpdateProductService $service, UpdateFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            UpdateProductDto::class
        );

        $command = new UpdateProduct($product, $dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }
}
