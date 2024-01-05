<?php

namespace App\Actions;

use App\Models\Fund;

class DeleteFundAction
{
    /**
     * @param Fund $fund
     * @return bool|null
     */
    public function execute(Fund $fund): bool | null
    {
        return $fund->delete();
    }
}