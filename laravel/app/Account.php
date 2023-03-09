<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'account_no', 'iban', 'type', 'branch_id', 'customer_id', 'balance'
    ];

    public function customer()
    {
      return $this->belongsTo('App\Customer');
    }

    public function branch()
    {
      return $this->belongsTo('App\Branch');
    }
}
