<?php

namespace App\Domain\Commands;

class UserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}
