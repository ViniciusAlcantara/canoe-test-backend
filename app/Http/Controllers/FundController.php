<?php

namespace App\Http\Controllers;

use App\Actions\CreateFundAction;
use App\Actions\DeleteFundAction;
use App\Actions\UpdateFundAction;
use App\Http\Requests\FundCreateRequest;
use App\Http\Requests\FundIndexRequest;
use App\Http\Requests\FundUpdateRequest;
use App\Repositories\Contracts\FundRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FundController extends Controller
{
    /**
     * @param FundIndexRequest $request
     * @param FundRepositoryInterface $fundRepository
     * @return Response
     */
    public function index(
        FundIndexRequest $request,
        FundRepositoryInterface $fundRepository,
    ): Response
    {
        try {
            $funds = $fundRepository->getFilteredFunds($request);

            return new Response(
                content: $funds,
                status: 200,
            );
        } catch (Exception $e) {
            return new Response(
                content:  [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                status: 400,
            );
        }
    }

    /**
     * @param FundCreateRequest $request
     * @param CreateFundAction $createFundAction
     * @return Response
     */
    public function create(
        FundCreateRequest $request,
        CreateFundAction $createFundAction,
    ): Response
    {
        try {
            // Adding a transaction because of the possibility of multiple inserts in another table/model (Alias)
            DB::beginTransaction();

            $fund = $createFundAction->execute($request);

            DB::commit();

            return new Response(
                content: $fund,
                status: 200,
            );
        } catch (Exception $e) {
            DB::rollBack();

            return new Response(
                content: [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                status: 400,
            );
        }
    }

    /**
     * @param FundUpdateRequest $request
     * @param UpdateFundAction $updateFundAction
     * @param FundRepositoryInterface $fundRepository
     * @return Response
     */
    public function update(
        FundUpdateRequest $request,
        UpdateFundAction $updateFundAction,
        FundRepositoryInterface $fundRepository,
    ): Response
    {
        try {            
            // Adding a transaction because of the possibility of multiple inserts/updates in another table/model (Alias)
            DB::beginTransaction();

            $fund = $fundRepository->find($request->fund_id);
            $fund = $updateFundAction->execute($request, $fund);

            DB::commit();

            return new Response(
                content: $fund,
                status: 200,
            );
        } catch (Exception $e) {
            DB::rollBack();

            return new Response(
                content:  [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                status: 400,
            );
        }
    }


    /**
     * @param Request $request
     * @param DeleteFundAction $deleteFundAction
     * @param FundRepositoryInterface $fundRepository
     * @return Response
     */
    public function delete(
        Request $request,
        DeleteFundAction $deleteFundAction,
        FundRepositoryInterface $fundRepository,
    ): Response
    {
        try {
            $fund = $fundRepository->find($request->fund_id);

            return new Response(
                content: $deleteFundAction->execute($fund),
                status: 200,
            );
        } catch (Exception $e) {
            return new Response(
                content:  [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                status: 400,
            );
        }
    }
}
