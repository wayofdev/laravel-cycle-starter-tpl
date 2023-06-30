<?php

declare(strict_types=1);

namespace Domain\Client;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Cycle\Database\DatabaseInterface;
use DateTimeImmutable;
use Exception;
use JsonSerializable;

final class BirthDate implements JsonSerializable
{
    private const FORMAT = 'Y-m-d';

    private DateTimeImmutable $date;

    public static function fromDate(DateTimeImmutable $date): self
    {
        return new self($date);
    }

    /**
     * @throws AssertionFailedException
     * @throws Exception
     */
    public static function fromString(string $date): self
    {
        Assertion::date($date, self::FORMAT);

        return new self(new DateTimeImmutable($date));
    }

    /**
     * @throws AssertionFailedException
     */
    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }

    public function toString(): string
    {
        return $this->date->format(self::FORMAT);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    private function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0);
    }
}
