<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\FundIndexRequest;
use App\Models\Fund;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface FundRepositoryInterface
{
    public function find(string $id): Fund;

    public function getFilteredFunds(FundIndexRequest $request): LengthAwarePaginator;

    public function checkDuplicateFund(Fund $fund): Collection;

    public function getDuplicatedFundsByFundManager(string $fundManagerId): Collection;
}