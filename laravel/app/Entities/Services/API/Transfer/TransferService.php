<?php

namespace App\Entities\Services\API\Transfer;

use App\Transfer;
use App\Account;
use Illuminate\Support\Facades\DB;

class TransferService
{
	/**
     * Transfer amounts between two accounts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function trnxAmountsBetweenTwoAccounts($request)
    {
        $data = array(); // Initialize return data array
        $input = $request->all();
        $sender_account_no = $input['sender_account_no'];
        $receiver_account_no = $input['receiver_account_no'];
        $trnx_amount = (float)$input['amount'];

        $sender_acc = Account::where('account_no', $sender_account_no)->first(); // Get sender acc info
        $receiver_acc = Account::where('account_no', $receiver_account_no)->first(); // Get receiver acc info
        $sender_acc_current_blc = (float)$sender_acc->balance;

        // If sender current balance is less than transfer amount, stop transfer
        if($sender_acc_current_blc < 1 || $sender_acc_current_blc < $trnx_amount) {
            return ['result' => false, 'data' => 'Insufficient balance in sender account '.$sender_account_no];
        }

        // Else add the transfer amount to receiver account balance and deduct amount from sender account balance
        DB::beginTransaction(); // Start DB tarnsaction

        $deduct_op = $this->updateAccountBalance($sender_acc, $trnx_amount, 'deduct');
        $add_op = $this->updateAccountBalance($receiver_acc, $trnx_amount, 'add');

        // create a record for transfer history
        $trnx_history_rec = Transfer::create([
            'sender_account_no'   => $sender_account_no,
            'receiver_account_no' => $receiver_account_no,
            'amount'              => $trnx_amount,
        ]);

        // If some issue happens during opertaions, roll back all changes related to current tranfser
        if(!$deduct_op || !$add_op || !$trnx_history_rec || NULL === $trnx_history_rec || empty($trnx_history_rec)) {
            DB::rollback();

            return ['result' => false, 'data' => 'Transfer failed, Try again later'];
        }

        // If everything goes smooth, valid and working
        // Commit the queries
        DB::commit();

        $data['sender_account_details'] = $sender_acc;
        $data['receiver_account_details'] = $receiver_acc;
        $data['current_transfer_record'] = $trnx_history_rec;
        return ['result' => true, 'data' => $data];
    }

    /**
     * Update Account balance with transfer amount
     *
     * @param  App\Account $account
     * @param  float
     * @param  string
     * @return bool
     */
    protected function updateAccountBalance(&$account, $trnx_amount, $operation)
    {
        $new_acc_blc = -1;
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
        if($account->save()) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve transfer history of a the given account number
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function fetchTransferHistoryByAccountNo($request)
    {
        $data = array(); // Initialize return data array
        $input = $request->all();
        $account_no = $input['account_no'];

        $transfer_history_recs = Transfer::where('sender_account_no', $account_no)->orWhere('receiver_account_no', $account_no)->get();

        // If no transfer history exists for given account number
        if($transfer_history_recs->count() < 1) {
            return ['result' => false, 'data' => 'No transfer history exists for account '.$account_no];
        }

        // Else structure the transfer history and return
        foreach ($transfer_history_recs as $rec) {
            $temp = array();
            $type = '';
            if($account_no == $rec->sender_account_no) { $type = 'sent'; }
            if($account_no == $rec->receiver_account_no) { $type = 'received'; }
            $temp['type'] = $type;
            $temp['sender_account_no'] = $rec->sender_account_no;
            $temp['sender_account_title'] = Account::where('account_no', $rec->sender_account_no)->value('title');
            $temp['receiver_account_no'] = $rec->receiver_account_no;
            $temp['receiver_account_title'] = Account::where('account_no', $rec->receiver_account_no)->value('title');
            $temp['created_at'] = $rec->created_at;

            $data['transfer_history'][] = $temp;
        }

        return ['result' => true, 'data' => $data];
    }
}