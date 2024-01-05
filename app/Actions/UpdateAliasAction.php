<?php

namespace App\Actions;

use App\Models\Alias;
use App\Repositories\Contracts\AliasRepositoryInterface;

class UpdateAliasAction
{
    public function __construct(private AliasRepositoryInterface $aliasRepository) {
    }

    /**
     * @param array $alias
     * @return Alias
     */
    public function execute(array $alias): Alias
    {
        $aliasModel = $this->aliasRepository->find($alias['id']);
        $aliasModel->alias = $alias['alias'];
        $aliasModel->save();

        return $aliasModel;
    }
}