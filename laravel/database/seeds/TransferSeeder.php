<?php

use Illuminate\Database\Seeder;
use App\Transfer;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dummy_transfer_history_rec = array(
        	0 => array(
	        	'sender_account_no' => '01006000000001',
	        	'receiver_account_no' => '01007000000001',
	        	'amount' => '100.00'
	        )
        );

        // Insert dummy transfer history rec in DB
        foreach ($dummy_transfer_history_rec as $rec){
            $trnx = new Transfer;
        	$trnx->sender_account_no = $rec['sender_account_no'];
        	$trnx->receiver_account_no = $rec['receiver_account_no'];
        	$trnx->amount = $rec['amount'];

        	$trnx->save();
        }
    }
}
