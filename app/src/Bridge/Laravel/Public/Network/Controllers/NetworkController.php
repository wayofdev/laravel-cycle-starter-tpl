<?php

declare(strict_types=1);

namespace Laravel\Public\Network\Controllers;

use Application\Network\Commands\Ping;
use Application\Network\Services\PingService;
use Assert\AssertionFailedException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'network',
    only: ['index'],
    names: 'api.public.network',
    shallow: true
)]
class NetworkController extends ApiController
{
    /**
     * @throws AssertionFailedException
     */
    #[OAT\Get(
        path: '/api/public/network',
        description: 'Get network status and requested by response.',
        summary: 'Network status.',
        tags: ['network']
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(?Authenticatable $user, PingService $service): Response
    {
        return $this->response->create(
            $service->handle(new Ping($user?->getFootprint()))
        );
    }
}
