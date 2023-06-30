<?php

declare(strict_types=1);

namespace Domain\Country;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;

#[Entity(table: 'country_states')]
class State
{
    #[Column(type: 'primary')]
    public int $id;

    #[Column(type: 'string')]
    public string $code;

    #[Column(type: 'string')]
    private string $name;

    #[BelongsTo(target: Country::class, innerKey: 'country_id', outerKey: 'id')]
    private Country $country;

    public function __construct(
        string $code,
        string $name,
        Country $country
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->country = $country;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function country(): Country
    {
        return $this->country;
    }
}
