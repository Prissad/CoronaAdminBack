<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    public function delegations()
    {
        return $this->hasMany('App\Delegation');
    }
}
