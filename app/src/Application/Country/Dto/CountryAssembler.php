<?php

declare(strict_types=1);

namespace Application\Country\Dto;

use Application\Country\Dto\Iso\ViewIsoDto;
use Application\Country\Dto\State\ViewStateDto;
use Domain\Country\Country;
use Domain\Country\Iso;
use Domain\Country\State;

final readonly class CountryAssembler
{
    public function toViewCountryDto(Country $country): ViewCountryDto
    {
        $dto = new ViewCountryDto();
        $dto->id = $country->id();
        $dto->name = $country->name();
        $dto->emoji = $country->emoji();
        $dto->code = $this->toViewIsoDto($country->code());
        $dto->states = $this->toViewStateDtoList($country);

        // $dto->created = $this->auth->toAuthSignatureDto($country->created());
        // $dto->updated = $this->auth->toAuthSignatureDto($country->updated());
        // $dto->deleted = null;

        // if (null !== $country->deleted()) {
        //     $dto->deleted = $this->auth->toAuthSignatureDto($country->deleted());
        // }

        return $dto;
    }

    public function toViewIsoDto(Iso $iso): ViewIsoDto
    {
        $dto = new ViewIsoDto();
        $dto->alpha2 = $iso->alpha2();
        $dto->alpha3 = $iso->alpha3();
        $dto->numeric = $iso->numeric();

        return $dto;
    }

    /**
     * @return ViewStateDto[]
     */
    public function toViewStateDtoList(Country $country): array
    {
        $output = [];

        foreach ($country->states() as $state) {
            $output[] = $this->toViewStateDto($state);
        }

        return $output;
    }

    private function toViewStateDto(State $state): ViewStateDto
    {
        $dto = new ViewStateDto();
        $dto->id = $state->id();
        $dto->name = $state->name();
        $dto->code = $state->code();

        return $dto;
    }
}
