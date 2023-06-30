<?php

declare(strict_types=1);

namespace Application\Category\Services;

use Application\Category\Commands\ListCategories;
use Application\Category\Dto\CategoryAssembler;
use Application\Category\Dto\ViewCategoryDto;
use Domain\Category\CategoryRepository;
use Domain\Shared\Api\Pagination\Pagination;
use WayOfDev\Paginator\CyclePaginator;
use WayOfDev\RQL\Bridge\Cycle\Criteria\FilterBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\LimitBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\OrderBy;

final readonly class ListCategoriesService
{
    public function __construct(
        private CategoryRepository $categories,
        private CategoryAssembler $assembler
    ) {
    }

    public function handle(ListCategories $command, Pagination $pagination): CyclePaginator
    {
        $criteria = $command->criteria();

        $this->categories->pushCriteria(new FilterBy($criteria->parameters()));
        $this->categories->pushCriteria(new LimitBy($criteria->limit()));
        $this->categories->pushCriteria(new OrderBy($criteria->orderBy()));

        $collection = $this->categories->paginate(
            perPage: $pagination->perPage(),
            page: $pagination->page()
        );
        $collection->getCollection()->transform(function ($item): ViewCategoryDto {
            return $this->assembler->toViewCategoryDto($item);
        });

        return $collection;
    }
}
