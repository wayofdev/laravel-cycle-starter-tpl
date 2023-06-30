<?php

declare(strict_types=1);

namespace Laravel\Admin\Order\Controllers;

use Application\Order\Commands\ListOrders;
use Application\Order\Commands\ViewOrder;
use Application\Order\Dto\QueryOrderDto;
use Application\Order\Dto\ViewOrderDto;
use Application\Order\Services\ListOrdersService;
use Application\Order\Services\ViewOrderService;
use Domain\Order\Order;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Http\Response;
use Laravel\Admin\Order\Requests\QueryFormRequest;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'orders',
    only: ['index', 'show'],
    names: 'api.admin.orders',
    shallow: true,
)]
class OrderController extends ApiController
{
    #[OAT\Get(
        path: '/api/admin/orders',
        description: 'This endpoint returns a list of orders in private collection.',
        summary: 'Get list of orders.',
        tags: ['orders']
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(Pagination $pagination, ListOrdersService $service, QueryFormRequest $request): Response
    {
        /** @var QueryOrderDto $requestQuery */
        $requestQuery = $request->toDto(new QueryOrderDto());

        $collection = $service->handle(
            new ListOrders($requestQuery),
            $pagination
        );

        return $this->response->fromArray(
            $collection->toArray()
        )->withHeaders($collection->headers());
    }

    #[OAT\Get(
        path: '/api/admin/orders/{order_id}',
        description: 'This endpoint returns a single order.',
        summary: 'Get single order.',
        tags: ['orders'],
        parameters: [
            new OAT\Parameter(
                name: 'order_id',
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
                schema: new OAT\Schema(ref: ViewOrderDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Order $order, ViewOrderService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewOrder($order))
        );
    }
}
