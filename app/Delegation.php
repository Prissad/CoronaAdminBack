<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    public function admins()
    {
        return $this->hasMany('App\Admin');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
