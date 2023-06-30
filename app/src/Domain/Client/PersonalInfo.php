<?php

declare(strict_types=1);

namespace Domain\Client;

use Assert\AssertionFailedException;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;
use Domain\Shared\Gender;

#[Embeddable]
class PersonalInfo
{
    #[Column(type: 'enum(male,female,other)', typecast: [Gender::class, 'castValue'])]
    private ?Gender $gender;

    #[Column(type: 'date', nullable: true, typecast: [BirthDate::class, 'castValue'])]
    private ?BirthDate $birthDate;

    /**
     * @throws AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['gender']) ? Gender::fromString($data['gender']) : null,
            isset($data['birthDate']) ? BirthDate::fromString($data['birthDate']) : null
        );
    }

    public function __construct(?Gender $gender, ?BirthDate $birthDate)
    {
        $this->gender = $gender;
        $this->birthDate = $birthDate;
    }

    public function gender(): ?Gender
    {
        return $this->gender;
    }

    public function birthDate(): ?BirthDate
    {
        return $this->birthDate;
    }

    public function toArray(): array
    {
        return [
            'gender' => $this->gender?->toString(),
            'birthDate' => $this->birthDate?->toString(),
        ];
    }
}
