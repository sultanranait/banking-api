<?php

namespace App\Http\Controllers\API\v1\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Services\API\Account\AccountService;
use App\Http\Requests\API\Account\GetBalanceRequest;
use App\Http\Requests\API\Account\CreateNewAccountRequest;
use App\Http\Responses\FailApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\AppConstant\AppConstant;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Endpoint for account services Api: Create a new account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateNewAccountRequest $request, AccountService $accountService)
    {
        try {
            $retData = $accountService->insertNewAccountInfo($request);
            if ($retData['result'] === true) {
                return new SuccessApiResponse($retData['data'], 'New customer bank account has been created successfully');
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
     * Endpoint for account services Api: Return the account balance
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getBalance(GetBalanceRequest $request, AccountService $accountService)
    {
        try {
            $retData = $accountService->getBalanceByAccountNo($request);
            if ($retData['result'] === true) {
                return new SuccessApiResponse($retData['data'], 'Account balance retrieved successfully');
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
