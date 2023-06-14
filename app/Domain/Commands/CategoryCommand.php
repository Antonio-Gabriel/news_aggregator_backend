<?php

namespace App\Domain\Commands;

class CategoryCommand
{
    public function __construct(
        public string $name
    ) {
    }
}
