<?php

declare(strict_types=1);

namespace Domain\Product\Code;

use Cycle\Database\DatabaseInterface;

final class Ian
{
    private string $ian;

    public static function fromString(string $ian): self
    {
        return new self($ian);
    }

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    public function toString(): string
    {
        return $this->ian;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function ian(): string
    {
        return $this->ian;
    }

    private function __construct(string $ian)
    {
        $this->ian = $ian;
    }
}
