<?php

declare(strict_types=1);

namespace Application\Order\Dto;

use Application\Auth\Dto\SignatureDto;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Order',
    description: 'Order response data.'
)]
final class ViewOrderDto
{
    #[OAT\Property(
        format: 'int64',
        example: 1
    )]
    public int $incrementalId;

    #[OAT\Property(format: 'uuid')]
    public string $id;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $created;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $updated;

    #[OAT\Property(schema: SignatureDto::class)]
    public ?SignatureDto $deleted;
}
