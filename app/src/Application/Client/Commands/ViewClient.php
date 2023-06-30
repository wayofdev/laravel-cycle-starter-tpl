<?php

declare(strict_types=1);

namespace Application\Client\Commands;

use Domain\Client\Client;

final readonly class ViewClient
{
    public function __construct(private Client $client)
    {
    }

    public function client(): Client
    {
        return $this->client;
    }
}
