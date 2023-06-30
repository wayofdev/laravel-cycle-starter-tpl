<?php

declare(strict_types=1);

namespace Domain\Cart;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(repository: CartRepository::class)]
class Item
{
    #[Column(type: 'bigPrimary')]
    public int $incrementalId;
}
