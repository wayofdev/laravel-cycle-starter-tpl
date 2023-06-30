<?php

declare(strict_types=1);

namespace Domain\Product\Factories;

use Domain\Auth\Footprint;
use Domain\Product\Code\Code;
use Domain\Product\Seo;
use Domain\Product\Status;

final readonly class ProductInput
{
    public function __construct(
        private string $name,
        private Status $status,
        private string $description,
        private string $categoryId,
        private Code $code,
        private Seo $seo,
        private Footprint $footprint
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function seo(): Seo
    {
        return $this->seo;
    }

    public function footprint(): Footprint
    {
        return $this->footprint;
    }
}
