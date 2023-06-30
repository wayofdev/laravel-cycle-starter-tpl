<?php

declare(strict_types=1);

namespace Application\Product\Services;

use Application\Product\Commands\ListProducts;
use Application\Product\Dto\ProductAssembler;
use Application\Product\Dto\ViewProductDto;
use Domain\Product\ProductRepository;
use Domain\Shared\Api\Pagination\Pagination;
use WayOfDev\Paginator\CyclePaginator;
use WayOfDev\RQL\Bridge\Cycle\Criteria\FilterBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\LimitBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\OrderBy;

final readonly class ListProductsService
{
    public function __construct(
        private ProductRepository $products,
        private ProductAssembler $assembler
    ) {
    }

    public function handle(ListProducts $command, Pagination $pagination): CyclePaginator
    {
        $criteria = $command->criteria();

        $this->products->pushCriteria(new FilterBy($criteria->parameters()));
        $this->products->pushCriteria(new LimitBy($criteria->limit()));
        $this->products->pushCriteria(new OrderBy($criteria->orderBy()));

        $collection = $this->products->paginate(
            perPage: $pagination->perPage(),
            page: $pagination->page()
        );

        $collection->getCollection()->transform(function ($item): ViewProductDto {
            return $this->assembler->toViewProductDto($item);
        });

        return $collection;
    }
}
