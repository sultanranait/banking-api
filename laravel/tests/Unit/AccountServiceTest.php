<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Services\API\Account\AccountService;
use App\Branch;

class AccountServiceTest extends TestCase
{
    /**
     * Test if account balance is fetchable by a given account number
     *
     * @return void
     */
    public function test_account_balance_is_fetchable_by_a_given_account_number()
    {
    	$request = new \Illuminate\Http\Request();
    	$request->setMethod('GET');
    	$request->query->add(['account_no' => '01006000000001']);

    	$account_service = new AccountService;
    	$retData = $account_service->getBalanceByAccountNo($request);

        $this->assertTrue($retData['result']);
    }

    /**
     * Test new account number generation
     *
     * @return void
     */
    public function test_new_account_number_generates_smoothly()
    {
    	$account_service = new AccountService;
    	$new_account_req_details = array(
    		'branch_id' => 1,
    		'type' => 'current'
    	);

        $branch_code = Branch::find($new_account_req_details['branch_id'])->code;
        $account_type = '6';
        if($new_account_req_details['type'] == 'savings') { $account_type = '7'; }

        $latest_inserted_acc_no = '01006000000002';
        $length = strlen($latest_inserted_acc_no);
	    $tokenize_acc_no[0] = substr($latest_inserted_acc_no, 0, 5);
	    $tokenize_acc_no[1] = substr($latest_inserted_acc_no, 5, $length);
        $new_acc_no_last_part = (string)(((int)$tokenize_acc_no[1]) + 1);
        $new_acc_no_last_part = str_pad($new_acc_no_last_part,9,0,STR_PAD_LEFT);
        
        $this->assertEquals('01006000000003', $branch_code.$account_type.$new_acc_no_last_part);
    }
}
