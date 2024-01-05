<?php

namespace App\Actions;

use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HandleMultipleAliasAction
{
    
    public function __construct(private UpdateAliasAction $updateAliasAction) {
    }
    /**
     * @param array $aliases
     * @param string $id
     * @return void
     */
    public function execute(array $aliases, string $id): void
    {
        foreach($aliases as $alias) {
            // Makes this action available for updates as well
            if (array_key_exists('id', $alias)) {
                $this->updateAliasAction->execute($alias);
                continue;
            }

            $aliasModel = new Alias();
            $aliasModel->id = Str::uuid();
            $aliasModel->alias = $alias['alias'];
            $aliasModel->fund_id = $id;

            $aliasModel->save();
        }
    }
}