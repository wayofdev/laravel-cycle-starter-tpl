<?php

declare(strict_types=1);

namespace Laravel\Public\Cart\Requests;

use WayOfDev\RQL\Bridge\Laravel\Http\Requests\ApiRequest;

final class StoreFormRequest extends ApiRequest
{
    public function rules(): array
    {
        return [];
    }
}
