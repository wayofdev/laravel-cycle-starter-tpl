<?php

declare(strict_types=1);

namespace Laravel\Admin\Product\Requests;

use WayOfDev\RQL\Bridge\Laravel\Http\Requests\ApiRequest;

final class UpdateFormRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => [''],
            'code.sku' => [''],
            'code.ian' => [''],
            'code.upc' => [''],
            'description' => [],
        ];
    }
}
