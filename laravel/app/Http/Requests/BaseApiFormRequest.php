<?php

namespace App\Http\Requests;

use App\AppConstant\ApiConstant;
use App\AppConstant\AppConstant;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

abstract class BaseApiFormRequest extends FormRequest
{
    use ApiResponse;

    /**
     * For more sanitizer rule check https://github.com/Waavi/Sanitizer
     */
    public function validateResolved()
    {
        {
            // $this->sanitize();
            parent::validateResolved();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->setMeta("status", AppConstant::STATUS_FAIL);
        $this->setMeta("message", $validator->messages()->first());
        // return redirect()->back();
        throw new HttpResponseException(response()->json($this->setResponse(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

}
