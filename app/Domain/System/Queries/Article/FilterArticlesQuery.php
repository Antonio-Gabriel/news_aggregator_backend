<?php

namespace App\Domain\System\Queries\Article;

use App\Domain\Interfaces\IArticleRepository;

class FilterArticlesQuery
{
    public function __construct(
        private IArticleRepository $repository
    ) {
    }

    public function applyFilters(mixed $query, string $attribute, ?string $values)
    {
        if (!is_null($values)) {
            $values = explode(',', $values);
            $query->whereIn($attribute, $values);
        }
    }

    public function query()
    {
        return $this->repository->getQuery();
    }
}
