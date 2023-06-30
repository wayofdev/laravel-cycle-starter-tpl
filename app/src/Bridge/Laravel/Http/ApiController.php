<?php

declare(strict_types=1);

namespace Laravel\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use WayOfDev\Serializer\Contracts\SerializerInterface;
use WayOfDev\Serializer\ResponseFactory;
use WayOfDev\Serializer\SerializerManager;

class ApiController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected ResponseFactory $response;

    protected SerializerInterface $serializer;

    public function __construct(
        ResponseFactory $response,
        SerializerManager $serializerManager
    ) {
        $this->response = $response;
        $this->serializer = $serializerManager->getSerializer('json');
    }
}
