<?php

namespace App\Http\Requests\API\Account;

use App\Http\Requests\BaseApiFormRequest;

class CreateNewAccountRequest extends BaseApiFormRequest
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
            'customer_details.first_name' => 'required',
            'customer_details.last_name' => 'required',
            'customer_details.email' => 'required|email',
            'customer_details.gender' => 'required',
            'customer_details.address' => 'required',
            'customer_details.city' => 'required',
            'new_account_info.title' => 'required|unique:accounts,title',
            'new_account_info.type' => 'required',
            'new_account_info.branch_id' => 'required',
            'new_account_info.initial_deposit_amount' => 'required|numeric|min:100'
        ];
    }
    public function messages()
    {
        return [
            'customer_details.first_name.required' => 'Customer first name is required',
            'customer_details.last_name.required' => 'Customer last name is required',
            'customer_details.email.required' => 'Customer email address is required',
            'customer_details.email.email' => 'Customer email address must be a valid email address',
            'customer_details.gender.required' => 'Customer gender is required',
            'customer_details.address.required' => 'Customer address is required',
            'customer_details.city.required' => 'Customer city is required',
            'new_account_info.title.required' => 'Account title is required',
            'new_account_info.title.unique' => 'Account title has already been taken',
            'new_account_info.type.required' => 'Account type is required',
            'new_account_info.branch_id.required' => 'Account branch id is required',
            'new_account_info.initial_deposit_amount.required' => 'Initial deposit amount is required',
            'new_account_info.initial_deposit_amount.numeric' => 'Initial deposit amount value must be numeric',
            'new_account_info.initial_deposit_amount.min' => 'Minimum initial deposit amount is 100.00',
        ];
    }
}
