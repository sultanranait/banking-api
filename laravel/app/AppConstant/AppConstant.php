<?php

namespace App\AppConstant;

class AppConstant
{
    /**
     * All app constants are being set here
     */

    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    const ACCEPTED_FAIL = 202;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_UNPROCESSABLE_ENTITY = 422;
    const FREETRIAL_NOTSUBSCRIBED = 0;
    const FREETRIAL_SUBSCRIBED = 1;
    const FREETRIAL_CLOSED = 2;
    const FREETRIAL_EXPIRED = 3;
    const PAYMENT_STATUS_NOTPAID = 0;
    const PAYMENT_STATUS_PAID = 1;
    const HTTP_NOT_FOUND = 404;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
}
