<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $table = 'delegations';
    public function admins()
    {
        return $this->hasMany('App\Admin');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
