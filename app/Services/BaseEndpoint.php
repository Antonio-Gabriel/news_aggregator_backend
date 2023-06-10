<?php

namespace App\Services;

use Illuminate\Support\Collection;

abstract class BaseEndpoint
{
    public function __construct(
        protected BaseApiService $service
    ) {
    }

    protected function transform(mixed $json, string $entity): Collection
    {
        return collect($json)
            ->map(fn ($resp) => new $entity($resp));
    }
}
