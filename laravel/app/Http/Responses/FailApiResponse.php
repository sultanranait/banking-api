<?php

namespace App\Http\Responses;

use App\AppConstant\AppConstant;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class FailApiResponse implements Responsable
{

    use ApiResponse;
    protected $code, $message;


    /**
     * BaseResponse constructor.
     * @param string $message
     * @param $code
     */
    function __construct(string $message, $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {

        return response()->json($this->responseBuilder(), $this->code);
    }

    /**
     * @return mixed
     */
    public function responseBuilder()
    {
        $this->setMeta("status", AppConstant::STATUS_FAIL);
        $this->setMeta("message", $this->message);
        return $this->setResponse();
    }
}
