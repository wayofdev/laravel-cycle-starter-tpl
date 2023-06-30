<?php

declare(strict_types=1);

namespace Domain\Category\Factories;

use Domain\Auth\Footprint;
use Domain\Shared\Gender;

final readonly class CategoryInput
{
    public function __construct(
        private string $name,
        private Gender $gender,
        private Footprint $footprint
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function gender(): Gender
    {
        return $this->gender;
    }

    public function footprint(): Footprint
    {
        return $this->footprint;
    }
}
