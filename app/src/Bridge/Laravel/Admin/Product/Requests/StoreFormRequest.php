<?php

declare(strict_types=1);

namespace Laravel\Admin\Product\Requests;

use Cycle\Database\DatabaseInterface;
use WayOfDev\Cycle\Bridge\Laravel\Rules\Exists;
use WayOfDev\Cycle\Bridge\Laravel\Rules\Unique;
use WayOfDev\RQL\Bridge\Laravel\Http\Requests\ApiRequest;

final class StoreFormRequest extends ApiRequest
{
    public function rules(DatabaseInterface $database): array
    {
        return [
            'name' => ['required'],
            'status' => ['required'],
            'description' => ['required'],
            'code.sku' => ['nullable', new Unique($database, 'products', 'code_sku')],
            'code.ian' => ['nullable', new Unique($database, 'products', 'code_ian')],
            'code.upc' => ['nullable', new Unique($database, 'products', 'code_upc')],
            'seo.slug' => ['nullable', new Unique($database, 'products', 'seo_slug')],
            'seo.title' => ['nullable'],
            'seo.description' => ['nullable'],
            'category.id' => ['required', 'uuid', new Exists($database, 'categories', 'id')],
        ];
    }
}
