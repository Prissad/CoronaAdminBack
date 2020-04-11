<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $table="posts";
    protected $fillable=['longitude','latitude','type','urlToImage',
        'time','description','affichage', 'delegation_id'];
}
