<?php

declare(strict_types=1);

namespace Laravel\Public\Country\Controllers;

use Application\Country\Commands\ListCountries;
use Application\Country\Commands\ViewCountry;
use Application\Country\Dto\QueryCountryDto;
use Application\Country\Dto\ViewCountryDto;
use Application\Country\Services\ListCountriesService;
use Application\Country\Services\ViewCountryService;
use Domain\Country\Country;
use Illuminate\Http\Response;
use Laravel\Http\ApiController;
use Laravel\Http\HttpStatus;
use Laravel\Public\Country\Requests\QueryFormRequest;
use OpenApi\Attributes as OAT;
use Spatie\RouteAttributes\Attributes\ApiResource;
use WayOfDev\Serializer\HttpCode;

#[ApiResource(
    resource: 'countries',
    only: ['index', 'show'],
    names: 'api.public.countries',
    shallow: true
)]
final class CountryController extends ApiController
{
    #[OAT\Get(
        path: '/api/public/countries',
        description: 'Get list of countries.',
        summary: 'Get list of countries.',
        tags: ['countries'],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function index(ListCountriesService $service, QueryFormRequest $request): Response
    {
        /** @var QueryCountryDto $requestQuery */
        $requestQuery = $request->toDto(new QueryCountryDto());

        $collection = $service->handle(new ListCountries($requestQuery));

        return $this->response->fromArray(
            $collection->toArray()
        );
    }

    #[OAT\Get(
        path: '/api/public/countries/{country_id}',
        description: 'This endpoint returns a single country.',
        summary: 'Get single country.',
        tags: ['countries'],
        parameters: [
            new OAT\Parameter(
                name: 'country_id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            ),
        ]
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_OK,
        description: HttpStatus::HTTP_OK,
        content: [
            new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(ref: ViewCountryDto::class)
            ),
        ],
    )]
    #[OAT\Response(
        response: HttpCode::HTTP_UNAUTHORIZED,
        description: HttpStatus::HTTP_UNAUTHORIZED
    )]
    public function show(Country $country, ViewCountryService $service): Response
    {
        return $this->response->create(
            $service->handle(new ViewCountry($country))
        );
    }
}
