<?php

namespace App\Actions;

use App\Http\Requests\FundUpdateRequest;
use App\Models\Fund;

class UpdateFundAction
{
    public function __construct(private HandleMultipleAliasAction $handleMultipleAliasAction) {
    }

    /**
     * @param FundUpdateRequest $request
     * @param Fund $fund
     * @return Fund
     */
    public function execute(FundUpdateRequest $request, Fund $fund): Fund
    {
        // Left the option to update all the fields besides the id
        // Although would probably be better not allow changes on fund_manager_id as well.
        if ($request->name) {
            $fund->name = $request->name;
        }

        if ($request->start_year) {
            $fund->start_year = $request->start_year;
        }

        if ($request->fund_manager_id) {
            $fund->fund_manager_id = $request->fund_manager_id;
        }
    
        if ($request->aliases && count($request->aliases) > 0) {
            $this->handleMultipleAliasAction->execute(aliases: $request->aliases, id: $fund->id);
        }

        $fund->save();

        return $fund->refresh()
            ->load('alias')
            ->load('fundManager');
    }
}