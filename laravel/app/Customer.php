<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender', 'address', 'city'
    ];

    public function accounts()
    {
      return $this->hasMany('App\Account');
    }
}
