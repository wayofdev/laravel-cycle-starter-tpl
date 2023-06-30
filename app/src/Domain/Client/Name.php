<?php

declare(strict_types=1);

namespace Domain\Client;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;

use function trim;

#[Embeddable]
class Name
{
    #[Column(type: 'string', nullable: true)]
    private ?string $firstName;

    #[Column(type: 'string', nullable: true)]
    private ?string $lastName;

    #[Column(type: 'string', nullable: true)]
    private ?string $middleName;

    public static function fromArray(array $data): self
    {
        return new self(
            $data['firstName'] ?? null,
            $data['lastName'] ?? null,
            $data['middleName'] ?? null
        );
    }

    public function __construct(?string $firstName, ?string $lastName, ?string $middleName)
    {
        $this->firstName = $firstName ? trim($firstName) : null;
        $this->lastName = $lastName ? trim($lastName) : null;
        $this->middleName = $middleName ? trim($middleName) : null;
    }

    public function firstName(): ?string
    {
        return $this->firstName;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }

    public function middleName(): ?string
    {
        return $this->middleName;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
        ];
    }
}
