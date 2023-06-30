<?php

declare(strict_types=1);

namespace Application\Country\Commands;

use Domain\Country\Country;

final readonly class ViewCountry
{
    public function __construct(private Country $country)
    {
    }

    public function country(): Country
    {
        return $this->country;
    }
}
