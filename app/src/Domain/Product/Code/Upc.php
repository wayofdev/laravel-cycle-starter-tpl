<?php

declare(strict_types=1);

namespace Domain\Product\Code;

use Cycle\Database\DatabaseInterface;

final class Upc
{
    private string $upc;

    public static function fromString(string $upc): self
    {
        return new self($upc);
    }

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    public function toString(): string
    {
        return $this->upc;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function upc(): string
    {
        return $this->upc;
    }

    private function __construct(string $upc)
    {
        $this->upc = $upc;
    }
}
