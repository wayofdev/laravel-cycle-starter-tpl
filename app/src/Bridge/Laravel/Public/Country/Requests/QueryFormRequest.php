<?php

declare(strict_types=1);

namespace Laravel\Public\Country\Requests;

use WayOfDev\RQL\Bridge\Laravel\Http\Requests\ApiRequest;

final class QueryFormRequest extends ApiRequest
{
    public function rules(): array
    {
        return [];
    }
}
