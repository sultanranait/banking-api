<?php

namespace App\Http\Responses;

use App\AppConstant\AppConstant;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class SuccessApiResponse implements Responsable
{

    use ApiResponse;
    protected $data, $message;


    /**
     * BaseResponse constructor.
     * @param $data
     * @param string $message
     */
    function __construct($data, string $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {

        return response()->json($this->responseBuilder(), JsonResponse::HTTP_OK);
    }

    /**
     * @return mixed
     */
    public function responseBuilder()
    {
        $this->setMeta("status", AppConstant::STATUS_SUCCESS);
        $this->setMeta("message", $this->message);
        if ($this->data) {
            if(!is_array($this->data)) {
                $this->data = [$this->data];
            }
            foreach ($this->data as $key => $value) {
                if($key=='incrementing' || $key=='exists' || $key=='wasRecentlyCreated' || $key=='timestamps' ){
                    continue;
                }
                $this->setData($key, $value);
            }
        }
        return $this->setResponse();
    }
}
