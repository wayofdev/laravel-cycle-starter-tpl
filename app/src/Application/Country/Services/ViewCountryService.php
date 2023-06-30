<?php

declare(strict_types=1);

namespace Application\Country\Services;

use Application\Country\Commands\ViewCountry;
use Application\Country\Dto\CountryAssembler;
use Application\Country\Dto\ViewCountryDto;

final readonly class ViewCountryService
{
    public function __construct(
        private CountryAssembler $assembler
    ) {
    }

    public function handle(ViewCountry $command): ViewCountryDto
    {
        return $this->assembler->toViewCountryDto($command->country());
    }
}
