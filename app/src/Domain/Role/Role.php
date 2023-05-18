<?php

declare(strict_types=1);

namespace Domain\Role;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(repository: RoleRepository::class)]
class Role
{
    #[Column(type: 'primary')]
    public int $id;

    #[Column(type: 'string')]
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
