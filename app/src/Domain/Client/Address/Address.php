<?php

declare(strict_types=1);

namespace Domain\Client\Address;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Domain\Auth\Signature;
use Domain\Client\AddressId;
use Domain\Client\AddressRepository;
use Domain\Client\Client;

#[Entity(
    repository: AddressRepository::class,
    table: 'client_addresses',
)]
class Address
{
    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [AddressId::class, 'castValue'], unique: true)]
    private AddressId $id;

    #[Column(type: 'enum(billing,shipping)', typecast: [Type::class, 'castValue'])]
    private Type $type;

    #[Column(type: 'boolean', default: false, typecast: 'bool')]
    private bool $isDefault;

    private string $firstName;

    private string $lastname;

    private string $phoneNumber;

    private string $postCode;

    private string $company;

    private string $country;

    private string $city;

    private string $addressLineFirst;

    private string $addressLineSecond;

    #[BelongsTo(target: Client::class, innerKey: 'client_id', outerKey: 'incremental_id')]
    private Client $client;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    public function __construct(
        AddressId $id,
        Type $type,
        bool $isDefault,
        Client $client,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->isDefault = $isDefault;
        $this->client = $client;
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();
    }

    public function incrementId(): int
    {
        return $this->incrementalId;
    }

    public function id(): AddressId
    {
        return $this->id;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function client(): Client
    {
        return $this->client;
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
        return $this->deleted;
    }
}
