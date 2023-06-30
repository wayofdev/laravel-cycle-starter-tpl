<?php

declare(strict_types=1);

namespace Domain\Shared\Api\Pagination;

final readonly class Pagination
{
    public function __construct(
        private int $page,
        private int $perPage
    ) {
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
