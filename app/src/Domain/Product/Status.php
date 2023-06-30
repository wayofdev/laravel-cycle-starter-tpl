<?php

declare(strict_types=1);

namespace Domain\Product;

use Cycle\Database\DatabaseInterface;
use Domain\Shared\StringEnum;

enum Status: string
{
    use StringEnum;

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    case ACTIVE = 'active';

    case DISABLED = 'disabled';

    case HIDDEN = 'hidden';
}
