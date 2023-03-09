<?php

namespace App\Http\Requests\API\Transfer;

use App\Http\Requests\BaseApiFormRequest;

class CreateNewTransferRequest extends BaseApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_account_no' => 'required|exists:accounts,account_no',
            'receiver_account_no' => 'required|exists:accounts,account_no',
            'amount' => 'required|numeric|min:1'
        ];
    }
    public function messages()
    {
        return [
            'sender_account_no.required' => 'Sender account number is required',
            'sender_account_no.exists' => 'Sender account number does not exist',
            'receiver_account_no.required' => 'Receiver account number is required',
            'receiver_account_no.exists' => 'Receiver account number does not exist',
            'amount.required' => 'Transfer amount is required',
            'amount.numeric' => 'Transfer amount must be a number',
            'amount.min' => 'Minimum transfer amount is 1.00'
        ];
    }
}
