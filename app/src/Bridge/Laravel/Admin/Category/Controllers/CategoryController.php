<?php

declare(strict_types=1);

namespace Laravel\Admin\Category\Controllers;

use Application\Category\Commands\ListCategories;
use Application\Category\Commands\StoreCategory;
use Application\Category\Commands\UpdateCategory;
use Application\Category\Commands\ViewCategory;
use Application\Category\Dto\QueryCategoryDto;
use Application\Category\Dto\StoreCategoryDto;
use Application\Category\Dto\UpdateCategoryDto;
use Application\Category\Dto\ViewCategoryDto;
use Application\Category\Services\ListCategoriesService;
use Application\Category\Services\StoreCategoryService;
use Application\Category\Services\UpdateCategoryService;
use Application\Category\Services\ViewCategoryService;
use Domain\Category\Category;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Admin\Category\Requests\QueryFormRequest;
use Laravel\Admin\Category\Requests\StoreFormRequest;
use Laravel\Admin\Category\Requests\UpdateFormRequest;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use Throwable;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'categories',
    only: ['index', 'show', 'store', 'update'],
    names: 'api.admin.categories',
    shallow: true
)]
class CategoryController extends ApiController
{
    #[OAT\Get(
        path: '/api/admin/categories',
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
        path: '/api/admin/categories/{category_id}',
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

    /**
     * @throws Throwable
     */
    #[OAT\Post(
        path: '/api/admin/categories',
        description: 'This endpoint stores new product into database storage.',
        summary: 'Store new product',
        tags: ['categories']
    )]
    #[OAT\RequestBody(
        description: 'Product data',
        required: true,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: StoreCategoryDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_CREATED,
        description: HttpStatus::HTTP_CREATED,
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
    #[OAT\Response(
        response: HttpCode::HTTP_UNPROCESSABLE_ENTITY,
        description: HttpStatus::HTTP_UNPROCESSABLE_ENTITY
    )]
    public function store(Authenticatable $user, StoreCategoryService $service, StoreFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            StoreCategoryDto::class
        );
        $command = new StoreCategory($dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }

    /**
     * @throws Throwable
     */
    #[OAT\Put(
        path: '/api/admin/categories/{category_id}',
        description: 'This endpoint updates fields of category.',
        summary: 'Update category contents.',
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
    #[OAT\RequestBody(
        description: 'Category data',
        required: true,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: UpdateCategoryDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_CREATED,
        description: HttpStatus::HTTP_CREATED,
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
    #[OAT\Response(
        response: HttpCode::HTTP_UNPROCESSABLE_ENTITY,
        description: HttpStatus::HTTP_UNPROCESSABLE_ENTITY
    )]
    public function update(Authenticatable $user, Category $category, UpdateCategoryService $service, UpdateFormRequest $request): Response
    {
        $dto = $this->serializer->unserialize(
            $request->getContent(),
            UpdateCategoryDto::class
        );

        $command = new UpdateCategory($category, $dto, $user->getFootprint());
        $product = $service->handle($command);

        $this->response->withStatusCode(HttpCode::HTTP_CREATED);

        return $this->response->create($product);
    }
}
