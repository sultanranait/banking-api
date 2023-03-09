<?php

namespace App\Traits;

trait ApiResponse
{
    protected $meta;
    protected $data;
    protected $paginate;
    protected $response;

    /**
     * Setter for meta values.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    /**
     * Setter for data values.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Setter method for response array.
     *
     * @param empty
     * @return mixed
     */
    protected function setResponse()
    {
        $this->response['meta'] = $this->meta;
        if ($this->data !== null) {
            $this->response['data'] = $this->data;
        }
        $this->meta = array();
        $this->data = array();
        $this->paginate = array();
        return $this->response;
    }
}