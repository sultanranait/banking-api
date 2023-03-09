<?php

namespace App\Entities\Services\API\Account;

use App\Account;
use App\Customer;
use App\Branch;

class AccountService
{
	/**
     * Retrieve balance amount on the given account number
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function getBalanceByAccountNo($request)
    {
    	$data = array('balance' => 0); // Initialize return data array
        $account = Account::whereAccount_no($request->account_no)->first();

        // If no account exists on this account number
        if(is_null($account) || empty($account)) {
            return ['result' => false, 'data' => 'Account not found'];
        }

        // Else return back the balance of this account number
        $balance = $account->balance;
        $data['balance'] = $balance;

        return ['result' => true, 'data' => $data];
    }

    /**
     * Insert new customer bank account information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function insertNewAccountInfo($request)
    {
    	$data = array(); // Initialize return data array
    	$input = $request->all();
    	$customer_req_details = $input['customer_details'];
    	$new_account_req_details = $input['new_account_info'];

    	// Get customer by unique email address
        $customer = Customer::whereEmail($customer_req_details['email'])->first();
        // If no customer exists on this email address, insert new customer details
        if(is_null($customer) || empty($customer)) {

        	$customer = Customer::create([
	            'first_name'   => $customer_req_details['first_name'],
	            'last_name'    => $customer_req_details['last_name'],
	            'email'        => $customer_req_details['email'],
	            'gender'       => $customer_req_details['gender'],
	            'address'      => $customer_req_details['address'],
	            'city'         => $customer_req_details['city'],
        	]);
        }
        $customer_id = $customer->id; //Customer_id to be stored with account info
        $new_account_no = $this->generateNewAccNo($new_account_req_details); // generate new unique acc no
        $new_iban = $this->generateNewIBAN($new_account_no); // generate new iban

        // Insert new account info in DB
        $account = Account::create([
            'title'        => $new_account_req_details['title'],
            'account_no'   => $new_account_no,
            'iban'         => $new_iban,
            'type'         => $new_account_req_details['type'],
            'branch_id'    => $new_account_req_details['branch_id'],
            'customer_id'  => $customer_id,
            'balance'      => $new_account_req_details['initial_deposit_amount'],
    	]);

        $data['customer'] = $customer;
        $data['account'] = $account;
        return ['result' => true, 'data' => $data];
    }

    /**
     * Generates new unique account number
     *
     * @param  array
     * @return string
     */
    protected function generateNewAccNo($new_account_req_details)
    {
    	// Get branch code
        $branch_code = Branch::find($new_account_req_details['branch_id'])->code;

        // Account type [ current => 6 | savings => 7]
        $account_type = '6';
        if($new_account_req_details['type'] == 'savings') { $account_type = '7'; }

        // last inserted account no
        $latest_inserted_acc_no = Account::whereType($new_account_req_details['type'])->latest('id')->first()->account_no;
        $tokenize_acc_no = $this->split_on($latest_inserted_acc_no, 5); // Split acc no into parts
        $new_acc_no_last_part = (string)(((int)$tokenize_acc_no[1]) + 1); // increment the last part of acc no
        $new_acc_no_last_part = str_pad($new_acc_no_last_part,9,0,STR_PAD_LEFT); // Left pad str with 0 
        
        // concat & return all parts of new account number
        return $branch_code.$account_type.$new_acc_no_last_part;
    }

    /**
     * Generates new unique IBAN
     *
     * @param  empty
     * @return string
     */
    protected function generateNewIBAN($account_no)
    {
    	return "US01BANK".$account_no;
    }

    /**
     * Splits string
     *
     * @param  string
     * @param  length of the returned string
     * @return array
     */
    protected function split_on($string, $num) {
	    $length = strlen($string);
	    $output[0] = substr($string, 0, $num);
	    $output[1] = substr($string, $num, $length);
	    return $output;
	}
}