<?php

declare(strict_types=1);

namespace Laravel\Public\Product\Controllers;

use Application\Product\Commands\ListProducts;
use Application\Product\Commands\ViewProduct;
use Application\Product\Dto\QueryProductDto;
use Application\Product\Dto\ViewProductDto;
use Application\Product\Services\ListProductsService;
use Application\Product\Services\ViewProductService;
use Domain\Product\Product;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use Laravel\Public\Product\Requests\QueryFormRequest;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'products',
    only: ['index', 'show'],
    names: 'api.public.products',
    shallow: true
)]
class ProductController extends ApiController
{
    #[OAT\Get(
        path: '/api/public/products',
        description: 'Get list of products',
        summary: 'Get list of products',
        tags: ['products'],
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
        path: '/api/public/products/{product_id}',
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
}
