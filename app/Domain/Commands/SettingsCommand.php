<?php

namespace App\Domain\Commands;

class SettingsCommand
{
    public function __construct(
        public ?int $user_id,
        public mixed $metadata
    ) {
    }
}
