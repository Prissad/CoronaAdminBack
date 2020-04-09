<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $table = 'delegations';
    public $timestamps = false;
    protected $fillable = ['name', 'gouvernorat_id'];

    public function admins()
    {
        return $this->hasMany('App\Admin');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
