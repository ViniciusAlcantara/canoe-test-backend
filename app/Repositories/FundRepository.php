<?php

namespace App\Repositories;

use App\Http\Requests\FundIndexRequest;
use App\Models\Fund;
use App\Repositories\Contracts\FundRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FundRepository implements FundRepositoryInterface
{
    public function find(string $id): Fund
    {
        return Fund::findOrFail($id);
    }

    public function getFilteredFunds(FundIndexRequest $request): LengthAwarePaginator
    {
        $query = Fund::query();

        if ($request->name) {
            $query->where('name', 'like', '%'. $request->name . '%');
        }

        if ($request->start_year) {
            $query->where('start_year', $request->start_year);
        }

        if ($request->fund_manager_id) {
            $query->where('fund_manager_id', $request->fund_manager_id);
        }

        return $query
            ->with('fundManager')
            ->with('alias')
            ->paginate($request->per_page ?? 15);
    }

    public function checkDuplicateFund(Fund $fund): Collection
    {
        $aliases = $fund->alias->map(fn ($al) => $al->alias);

        $duplicates = Fund::select("id")
            ->where('fund_manager_id', $fund->fund_manager_id)
            ->where('name', $fund->name)
            ->where('duplicated', false)
            ->whereHas('alias', function ($query) use ($aliases) {
                $query->whereIn('alias', $aliases);
            })
            ->get();

        return $duplicates;
    }

    public function getDuplicatedFundsByFundManager(string $fundManagerId): Collection
    {
        return Fund::where('fund_manager_id', $fundManagerId)
            ->where('duplicated', true)
            ->with('fundManager')
            ->with('alias')
            ->get();
    }
}