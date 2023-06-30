<?php

declare(strict_types=1);

namespace Domain\Client;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Domain\Auth\Signature;
use Domain\Auth\UserId;
use Domain\Client\Address\Address;
use Domain\Client\Events\ClientCreated;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use Illuminate\Support\Collection;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRoot;

#[Entity(repository: ClientRepository::class)]
class Client implements AggregateRoot
{
    use AggregatableRoot;

    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [ClientId::class, 'castValue'], unique: true)]
    private ClientId $id;

    #[Column(type: 'uuid', nullable: true, unique: true)]
    private ?UserId $userId = null;

    #[Column(type: 'string', nullable: true)]
    private ?string $email = null;

    #[Column(type: 'string', nullable: true)]
    private ?string $username = null;

    #[Embedded(target: Name::class)]
    private Name $name;

    #[Embedded(target: PersonalInfo::class)]
    private ?PersonalInfo $personalInfo;

    #[Column(type: 'string', nullable: true)]
    private ?string $company = null;

    #[HasMany(target: Address::class, innerKey: 'incremental_id', outerKey: 'client_id', nullable: true)]
    private Collection $addresses;

    // private Consents $consents;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    public function __construct(
        ClientId $id,
        ?UserId $userId,
        ?string $email,
        ?string $username,
        Name $name,
        ?PersonalInfo $personalInfo,
        ?string $company,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->email = $email;
        $this->username = $username;
        $this->name = $name;
        $this->personalInfo = $personalInfo;
        $this->company = $company;
        $this->addresses = new Collection();
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();

        $this->recordThat(new ClientCreated(
            $id,
            $userId,
            $email,
            $username,
            $name,
            $company,
            $signature,
        ));
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    public function incrementalId(): int
    {
        return $this->incrementalId;
    }

    public function id(): ClientId
    {
        return $this->id;
    }

    public function userId(): ?UserId
    {
        return $this->userId;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function firstName(): ?string
    {
        return $this->name->firstName();
    }

    public function lastName(): ?string
    {
        return $this->name->lastName();
    }

    public function personalInfo(): ?PersonalInfo
    {
        return $this->personalInfo;
    }

    public function company(): ?string
    {
        return $this->company;
    }

    public function username(): ?string
    {
        return $this->username;
    }

    public function addresses(): ?Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): void
    {
        $this->addresses->add($address);
    }

    public function removeAddress(Address $address): void
    {
        $this->addresses = $this->addresses->reject(function ($a) use ($address) {
            return $a === $address;
        });
    }

    public function created(): Signature
    {
        return $this->created;
    }

    public function updated(): Signature
    {
        return $this->updated;
    }

    public function deleted(): ?Signature
    {
        if (! $this->deleted?->defined()) {
            return null;
        }

        return $this->deleted;
    }
}
