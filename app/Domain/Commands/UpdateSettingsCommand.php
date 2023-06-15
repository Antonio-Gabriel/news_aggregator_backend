<?php

namespace App\Domain\Commands;

class UpdateSettingsCommand
{
    public function __construct(
        public mixed $metadata
    ) {
    }
}
