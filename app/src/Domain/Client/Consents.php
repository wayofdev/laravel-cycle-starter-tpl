<?php

declare(strict_types=1);

namespace Domain\Client;

use JsonSerializable;

final class Consents implements JsonSerializable
{
    private array $values;

    public static function blank(): self
    {
        return new self([]);
    }

    public static function fromArray(array $values): self
    {
        return new self($values);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public function satisfies(self $accepted): bool
    {
        foreach ($this->values as $field => $required) {
            if ($required && empty($accepted->values[$field])) {
                return false;
            }
        }

        return true;
    }

    private function __construct(array $values)
    {
        $this->values = $values;
    }
}
