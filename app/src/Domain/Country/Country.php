<?php

declare(strict_types=1);

namespace Domain\Country;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Illuminate\Support\Collection;

#[Entity(repository: CountryRepository::class)]
class Country
{
    #[Column(type: 'string', primary: true)]
    private string $id;

    #[Column(type: 'string')]
    private string $name;

    #[Embedded(target: Iso::class, prefix: 'iso_')]
    private Iso $code;

    #[Column(type: 'string')]
    private string $emoji;

    #[HasMany(target: State::class, innerKey: 'id', outerKey: 'country_id', load: 'eager')]
    private Collection $states;

    public function __construct(
        string $id,
        string $name,
        Iso $code,
        string $emoji
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->emoji = $emoji;
        $this->states = new Collection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): Iso
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function emoji(): string
    {
        return $this->emoji;
    }

    public function states(): Collection
    {
        return $this->states;
    }
}
