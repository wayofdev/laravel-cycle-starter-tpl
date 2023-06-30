<?php

declare(strict_types=1);

namespace Laravel\Public\Category\Controllers;

use Application\Category\Commands\ListCategories;
use Application\Category\Commands\ViewCategory;
use Application\Category\Dto\QueryCategoryDto;
use Application\Category\Dto\ViewCategoryDto;
use Application\Category\Services\ListCategoriesService;
use Application\Category\Services\ViewCategoryService;
use Domain\Category\Category;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use Laravel\Public\Category\Requests\QueryFormRequest;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'categories',
    only: ['index', 'show'],
    names: 'api.public.categories',
    shallow: true
)]
final class CategoryController extends ApiController
{
    #[OAT\Get(
        path: '/api/public/categories',
        description: 'Get list of categories.',
        summary: 'Get list of categories.',
        tags: ['categories'],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(Pagination $pagination, ListCategoriesService $service, QueryFormRequest $request): Response
    {
        /** @var QueryCategoryDto $requestQuery */
        $requestQuery = $request->toDto(new QueryCategoryDto());

        $collection = $service->handle(
            new ListCategories($requestQuery),
            $pagination
        );

        return $this->response->fromArray(
            $collection->toArray()
        )->withHeaders($collection->headers());
    }

    #[OAT\Get(
        path: '/api/public/categories/{category_id}',
        description: 'This endpoint returns a single category.',
        summary: 'Get single category.',
        tags: ['categories'],
        parameters: [
            new OAT\Parameter(
                name: 'category_id',
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
                schema: new OAT\Schema(ref: ViewCategoryDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Category $category, ViewCategoryService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewCategory($category))
        );
    }
}
