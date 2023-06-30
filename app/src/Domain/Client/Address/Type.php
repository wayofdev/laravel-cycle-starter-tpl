<?php

declare(strict_types=1);

namespace Domain\Client\Address;

use Cycle\Database\DatabaseInterface;
use Domain\Shared\StringEnum;

enum Type: string
{
    use StringEnum;

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    case BILLING = 'billing';

    case SHIPPING = 'shipping';
}
