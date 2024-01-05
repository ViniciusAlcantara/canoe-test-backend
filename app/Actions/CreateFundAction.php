<?php

namespace App\Actions;

use App\Events\DuplicatedFundWarningEvent;
use App\Http\Requests\FundCreateRequest;
use App\Models\Fund;
use App\Repositories\Contracts\FundRepositoryInterface;
use Illuminate\Support\Str;

class CreateFundAction
{
    public function __construct(
        private HandleMultipleAliasAction $handleMultipleAliasAction,
        private FundRepositoryInterface $fundRepository,
    ) {
    }

    /**
     * @param FundCreateRequest $request
     * @return Fund
     */
    public function execute(FundCreateRequest $request): Fund
    {
        $fund = new Fund();
        $fund->id = Str::uuid();
        $fund->name = $request->name;
        $fund->start_year = $request->start_year;
        $fund->fund_manager_id = $request->fund_manager_id;
        $fund->duplicated = false;

        $fund->save();

        $fund->refresh();

        if ($request->aliases && count($request->aliases) > 0) {
            $this->handleMultipleAliasAction->execute(aliases: $request->aliases, id: $fund->id);
        }

        $duplicates = $this->fundRepository->checkDuplicateFund($fund);
        if ($duplicates->count() > 1) {
            DuplicatedFundWarningEvent::dispatch($duplicates);
        }

        return $fund
            ->load('alias')
            ->load('fundManager');
    }
}