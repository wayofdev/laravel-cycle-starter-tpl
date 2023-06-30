<?php

declare(strict_types=1);

namespace Application\Order\Services;

use Application\Order\Commands\ListOrders;
use Application\Order\Dto\OrderAssembler;
use Application\Order\Dto\ViewOrderDto;
use Domain\Order\OrderRepository;
use Domain\Shared\Api\Pagination\Pagination;
use WayOfDev\Paginator\CyclePaginator;
use WayOfDev\RQL\Bridge\Cycle\Criteria\FilterBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\LimitBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\OrderBy;

final readonly class ListOrdersService
{
    public function __construct(
        private OrderRepository $categories,
        private OrderAssembler $assembler
    ) {
    }

    public function handle(ListOrders $command, Pagination $pagination): CyclePaginator
    {
        $criteria = $command->criteria();

        $this->categories->pushCriteria(new FilterBy($criteria->parameters()));
        $this->categories->pushCriteria(new LimitBy($criteria->limit()));
        $this->categories->pushCriteria(new OrderBy($criteria->orderBy()));

        $collection = $this->categories->paginate(
            perPage: $pagination->perPage(),
            page: $pagination->page()
        );
        $collection->getCollection()->transform(function ($item): ViewOrderDto {
            return $this->assembler->toViewOrderDto($item);
        });

        return $collection;
    }
}
