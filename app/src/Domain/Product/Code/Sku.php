<?php

declare(strict_types=1);

namespace Domain\Product\Code;

use Cycle\Database\DatabaseInterface;

final class Sku
{
    private string $sku;

    public static function fromString(string $sku): self
    {
        return new self($sku);
    }

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    public function toString(): string
    {
        return $this->sku;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function sku(): string
    {
        return $this->sku;
    }

    private function __construct(string $sku)
    {
        $this->sku = $sku;
    }
}
