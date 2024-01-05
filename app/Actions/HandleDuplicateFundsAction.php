<?php

namespace App\Actions;

use App\Http\Requests\FundUpdateRequest;
use App\Models\Fund;
use App\Repositories\Contracts\FundRepositoryInterface;
use Illuminate\Support\Collection;

class HandleDuplicateFundsAction
{
    public function __construct(private FundRepositoryInterface $fundRepository) {
    }

    /**
     * @param FundUpdateRequest $request
     * @param Fund $fund
     * @return Fund
     */
    public function execute(array $duplicates): void
    {
        foreach($duplicates as $duplicated) {
            $fundModel = $this->fundRepository->find($duplicated->id);
            $fundModel->duplicated = true;
            $fundModel->save();
        }
    }
}