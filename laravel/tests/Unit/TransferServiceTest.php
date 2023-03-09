<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Services\API\Transfer\TransferService;
use App\Account;

class TransferServiceTest extends TestCase
{
    /**
     * Test if transfer history is fetchable for a given account number
     *
     * @return void
     */
    public function test_transfer_history_is_fetchable_for_a_given_account_number()
    {
    	$request = new \Illuminate\Http\Request();
    	$request->setMethod('GET');
    	$request->query->add(['account_no' => '01006000000001']);

    	$transfer_service = new TransferService;
    	$retData = $transfer_service->fetchTransferHistoryByAccountNo($request);

        $this->assertTrue($retData['result']);
    }

    /**
     * Test account balance adds smoothly
     *
     * @return void
     */
    public function test_account_balance_adds_smoothly_for_a_given_account_number()
    {
    	$new_acc_blc = -1;
    	$operation = 'add';
    	$acc_no = '01006000000001';
    	$trnx_amount = (float)1.00;
    	$account = Account::where('account_no', $acc_no)->first();
        $acc_blc = (float)$account->balance;

        if($operation == 'deduct') {
            // deduct
            $new_acc_blc = $acc_blc - $trnx_amount;
        }
        if($operation == 'add') {
            // add
            $new_acc_blc = $acc_blc + $trnx_amount;
        }
        // issues in updated account balance
        if($new_acc_blc < 0) {
            return false;
        }

        // update balance
        $account->balance = $new_acc_blc;
        $result = $account->save();

        $this->assertTrue($result);
    }

    /**
     * Test account balance deducts smoothly
     *
     * @return void
     */
    public function test_account_balance_deducts_smoothly_for_a_given_account_number()
    {
    	$new_acc_blc = -1;
    	$operation = 'deduct';
    	$acc_no = '01006000000001';
    	$trnx_amount = (float)1.00;
    	$account = Account::where('account_no', $acc_no)->first();
        $acc_blc = (float)$account->balance;

        if($operation == 'deduct') {
            // deduct
            $new_acc_blc = $acc_blc - $trnx_amount;
        }
        if($operation == 'add') {
            // add
            $new_acc_blc = $acc_blc + $trnx_amount;
        }
        // issues in updated account balance
        if($new_acc_blc < 0) {
            return false;
        }

        // update balance
        $account->balance = $new_acc_blc;
        $result = $account->save();

        $this->assertTrue($result);
    }
}
