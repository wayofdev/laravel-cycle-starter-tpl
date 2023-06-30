<?php

declare(strict_types=1);

namespace Laravel\Admin\Category\Requests;

use WayOfDev\RQL\Bridge\Laravel\Http\Requests\ApiRequest;

final class QueryFormRequest extends ApiRequest
{
    public function rules(): array
    {
        return [];
    }
}
