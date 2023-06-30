<?php

declare(strict_types=1);

namespace Domain\Auth;

use Assert\Assert;
use Assert\AssertionFailedException;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;

#[Embeddable]
class Signature
{
    #[Column(type: 'datetime', nullable: true)]
    private ?DateTimeImmutable $at = null;

    #[Column(type: 'json', nullable: true, typecast: [Footprint::class, 'castValue'])]
    private ?Footprint $by = null;

    /**
     * @throws AssertionFailedException
     */
    public static function random(): self
    {
        return new self(new DateTimeImmutable(), Footprint::random());
    }

    public static function empty(): self
    {
        return new self(new DateTimeImmutable(), null);
    }

    /**
     * @throws Exception|AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        Assert::that($data)
            ->keyExists('at')
            ->keyExists('by')
        ;

        return new self(
            new DateTimeImmutable($data['at']),
            Footprint::fromArray($data['by']),
        );
    }

    public function defined(): bool
    {
        return isset($this->at, $this->by);
    }

    public function at(): ?DateTimeImmutable
    {
        return $this->at;
    }

    public function by(): ?Footprint
    {
        return $this->by;
    }

    public function toArray(): array
    {
        return [
            'at' => $this->at?->format(DateTimeInterface::RFC3339_EXTENDED),
            'by' => $this->by?->toArray(),
        ];
    }

    public function __construct(?DateTimeImmutable $at, ?Footprint $by)
    {
        $this->at = $at;
        $this->by = $by;
    }
}
