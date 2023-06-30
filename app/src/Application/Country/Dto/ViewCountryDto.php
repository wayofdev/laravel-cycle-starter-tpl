<?php

declare(strict_types=1);

namespace Application\Country\Dto;

use Application\Country\Dto\Iso\ViewIsoDto;
use Application\Country\Dto\State\ViewStateDto;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Country',
    description: 'Country response data.'
)]
final class ViewCountryDto
{
    #[OAT\Property(
        format: 'string',
        example: 'lv'
    )]
    public string $id;

    #[OAT\Property(example: 'Latvia')]
    public string $name;

    #[OAT\Property(format: 'string', example: '🇱🇻')]
    public string $emoji;

    #[OAT\Property(schema: ViewIsoDto::class)]
    public ViewIsoDto $code;

    /**
     * @var ViewStateDto[]
     */
    public array $states;
}
