<?php

declare(strict_types=1);

namespace Domain\Product\Code;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;

#[Embeddable]
class Code
{
    #[Column(type: 'string', nullable: true, typecast: [Sku::class, 'castValue'], unique: true)]
    private ?Sku $sku;

    #[Column(type: 'string', nullable: true, typecast: [Ian::class, 'castValue'], unique: true)]
    private ?Ian $ian;

    #[Column(type: 'string', nullable: true, typecast: [Upc::class, 'castValue'], unique: true)]
    private ?Upc $upc;

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['sku']) ? Sku::fromString($data['sku']) : null,
            isset($data['ian']) ? Ian::fromString($data['ian']) : null,
            isset($data['upc']) ? Upc::fromString($data['upc']) : null
        );
    }

    public function __construct(?Sku $sku, ?Ian $ian, ?Upc $upc)
    {
        $this->sku = $sku;
        $this->ian = $ian;
        $this->upc = $upc;
    }

    public function sku(): ?Sku
    {
        return $this->sku;
    }

    public function ian(): ?Ian
    {
        return $this->ian;
    }

    public function upc(): ?Upc
    {
        return $this->upc;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku?->toString(),
            'ian' => $this->ian?->toString(),
            'upc' => $this->upc?->toString(),
        ];
    }

    public function merge(self $other): self
    {
        return new self(
            $other->sku ?? $this->sku,
            $other->ian ?? $this->ian,
            $other->upc ?? $this->upc
        );
    }
}
