<?php

namespace App\Repositories;

use App\Models\Alias;
use App\Repositories\Contracts\AliasRepositoryInterface;

class AliasRepository implements AliasRepositoryInterface
{
    public function find(string $id): Alias
    {
        return Alias::findOrFail($id);
    }
}