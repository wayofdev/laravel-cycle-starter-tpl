<?php

declare(strict_types=1);

namespace Domain\User;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Domain\Role\Role;
use Illuminate\Support\Collection;

/**
 * @see https://cycle-orm.dev/docs/annotated-entity/2.x/en
 */
#[Entity(
    repository: UserRepository::class,
    table: 'users',
    // scope: \App\Scope\SortByID::class
)]
final class User
{
    #[Column(type: 'bigInteger', primary: true)]
    private ?int $incrementalId = null;

    #[Column(type: 'string', nullable: true)]
    public ?string $email = null;

    #[Column(type: 'string', nullable: true)]
    public ?string $company = null;

    #[HasMany(target: Role::class)]
    public Collection $roles;

    public function __construct(
        #[Column(type: 'string')]
        private string $name
    ) {
        $this->roles = new Collection();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
