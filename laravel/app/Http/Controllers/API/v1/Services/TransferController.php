<?php

namespace App\Http\Controllers\API\v1\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Services\API\Transfer\TransferService;
use App\Http\Requests\API\Transfer\CreateNewTransferRequest;
use App\Http\Requests\API\Transfer\GetTransferHistoryRequest;
use App\Http\Responses\FailApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\AppConstant\AppConstant;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Endpoint for transfer services Api: Transfer amounts between any two accounts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateNewTransferRequest $request, TransferService $transferService)
    {
        try {
            $retData = $transferService->trnxAmountsBetweenTwoAccounts($request);
            if ($retData['result'] === true) {
                return new SuccessApiResponse($retData['data'], 'Amount has been transferred successfully');
            } else {
                return new FailApiResponse($retData['data'], AppConstant::HTTP_EXPECTATION_FAILED);
            }

            return new FailApiResponse('Something went wrong', AppConstant::HTTP_EXPECTATION_FAILED);
        } catch (QueryException $e) { // Catch any database/query exceptions
            DB::rollBack(); // Rollback any database commits
            return new FailApiResponse($e->getMessage());
        } catch (ClientException $e) { // Exception when a client error is encountered
            DB::rollBack();
            return new FailApiResponse($e->getMessage());
        }
    }

    /**
     * Endpoint for transfer services Api: Fetch transfer history for a given account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(GetTransferHistoryRequest $request, TransferService $transferService)
    {
        try {
            $retData = $transferService->fetchTransferHistoryByAccountNo($request);
            if ($retData['result'] === true) {
                return new SuccessApiResponse($retData['data'], 'Transfer history has been retrieved successfully');
            } else {
                return new FailApiResponse($retData['data'], AppConstant::HTTP_EXPECTATION_FAILED);
            }

            return new FailApiResponse('Something went wrong', AppConstant::HTTP_EXPECTATION_FAILED);
        } catch (QueryException $e) { // Catch any database/query exceptions
            DB::rollBack(); // Rollback any database commits
            return new FailApiResponse($e->getMessage());
        } catch (ClientException $e) { // Exception when a client error is encountered
            DB::rollBack();
            return new FailApiResponse($e->getMessage());
        }
    }
}
