<?php

declare(strict_types=1);

namespace Domain\Shared;

use Cycle\Database\DatabaseInterface;

enum Gender: string
{
    use StringEnum;

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    case MALE = 'male';

    case FEMALE = 'female';

    case OTHER = 'other';
}
