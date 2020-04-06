<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    protected $table = 'gouvernorats';
    public function delegations()
    {
        return $this->hasMany('App\Delegation');
    }
}
