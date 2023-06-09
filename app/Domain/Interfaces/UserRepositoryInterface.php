<?php

namespace App\Domain\Interfaces;

interface UserRepositoryInterface
{
    public function exists(): bool;
}
