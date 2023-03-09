<?php

namespace App\Http\Requests\API\Transfer;

use App\Http\Requests\BaseApiFormRequest;

class GetTransferHistoryRequest extends BaseApiFormRequest
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
            'account_no' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'account_no.required' => 'Account number is required'
        ];
    }
}
