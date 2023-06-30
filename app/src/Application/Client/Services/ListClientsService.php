<?php

declare(strict_types=1);

namespace Application\Client\Services;

use Application\Client\Commands\ListClients;
use Application\Client\Dto\ClientAssembler;
use Application\Client\Dto\ViewClientDto;
use Domain\Client\ClientRepository;
use Domain\Shared\Api\Pagination\Pagination;
use WayOfDev\Paginator\CyclePaginator;
use WayOfDev\RQL\Bridge\Cycle\Criteria\FilterBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\LimitBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\OrderBy;

final readonly class ListClientsService
{
    public function __construct(
        private ClientRepository $clients,
        private ClientAssembler $assembler
    ) {
    }

    public function handle(ListClients $command, Pagination $pagination): CyclePaginator
    {
        $criteria = $command->criteria();

        $this->clients->pushCriteria(new FilterBy($criteria->parameters()));
        $this->clients->pushCriteria(new LimitBy($criteria->limit()));
        $this->clients->pushCriteria(new OrderBy($criteria->orderBy()));

        $collection = $this->clients->paginate(
            perPage: $pagination->perPage(),
            page: $pagination->page()
        );
        $collection->getCollection()->transform(function ($item): ViewClientDto {
            return $this->assembler->toViewClientDto($item);
        });

        return $collection;
    }
}
