<?php

namespace App\Repositories\Contracts;

use App\Models\Alias;

interface AliasRepositoryInterface
{
    public function find(string $id): Alias;
}