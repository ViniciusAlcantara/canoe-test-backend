<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\FundRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DuplicatedFundsController extends Controller
{
    /**
     * @param Request $request
     * @param FundRepositoryInterface $fundRepository
     * @return Response
     */
    public function __invoke(
        Request $request,
        FundRepositoryInterface $fundRepository,
    ): Response
    {
        try {
            $duplicated_funds = $fundRepository->getDuplicatedFundsByFundManager($request->fund_manager_id);

            return new Response(
                content: $duplicated_funds,
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
