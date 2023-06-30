<?php

declare(strict_types=1);

namespace Application\Network\Services;

use Application\Network\Commands\Ping;
use Application\Network\Dto\NetworkAssembler;
use Application\Network\Dto\NetworkDto;
use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Lcobucci\Clock\Clock;

final readonly class PingService
{
    public function __construct(
        private Clock $clock,
        private NetworkAssembler $assembler
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    public function handle(Ping $command): NetworkDto
    {
        $signature = new Signature($this->clock->now(), $command->footprint());

        return $this->assembler->toNetworkDto($signature);
    }
}
