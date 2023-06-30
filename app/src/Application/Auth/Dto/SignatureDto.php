<?php

declare(strict_types=1);

namespace Application\Auth\Dto;

use DateTimeImmutable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Signature',
    description: 'Signature data.'
)]
final class SignatureDto
{
    #[OAT\Property(format: 'date-time')]
    public ?DateTimeImmutable $at;

    #[OAT\Property(schema: FootprintDto::class)]
    public ?FootprintDto $by;
}
