<?php

declare(strict_types=1);

namespace Database\Seeders;

use Cycle\ORM\EntityManager;
use Domain\Country\Country;
use Domain\Country\Iso;
use Domain\Country\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JsonException;
use Rinvex\Country\Country as RinvexCountry;
use Rinvex\Country\CountryLoader;
use Throwable;

use function file_get_contents;
use function in_array;
use function json_decode;

final class CountrySeeder extends Seeder
{
    private const COUNTRIES_WITH_STATES = [
        'US',
        'MX',
        'CA',
    ];

    private Collection $states;

    /**
     * @throws JsonException
     */
    public function __construct(
        private readonly EntityManager $entityManager,
    ) {
        $this->states = new Collection(
            json_decode(file_get_contents(__DIR__ . '/data/states.json'), false, 512, JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws Throwable
     */
    public function run(): void
    {
        // DB::table('country_states')->truncate();
        // DB::table('countries')->truncate();

        /** @var RinvexCountry[] $countries */
        $countries = CountryLoader::countries(true, true);

        // create a map of Country entities keyed by country_code
        $countryMap = [];

        foreach ($countries as $country) {
            $entity = new Country(
                id: $country->getIsoAlpha2(),
                name: $country->getName(),
                code: Iso::fromArray([
                    'alpha2' => $country->getIsoAlpha2(),
                    'alpha3' => $country->getIsoAlpha3(),
                    'numeric' => $country->getIsoNumeric(),
                ]),
                emoji: $country->getEmoji(),
            );

            if (in_array($country->getIsoAlpha2(), self::COUNTRIES_WITH_STATES, true)) {
                $countryMap[$entity->id()] = $entity;
            }

            $this->entityManager->persist($entity);
        }

        foreach ($countryMap as $country) {
            foreach ($this->getStates($country->id()) as $state) {
                $stateEntity = new State(
                    code: $state->state_code,
                    name: $state->name,
                    country: $country
                );

                $this->entityManager->persist($stateEntity);
            }
        }

        $this->entityManager->run();
    }

    private function getStates($countryCode): Collection
    {
        return $this->states->where('country_code', $countryCode);
    }
}
