<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table="posts";
    protected $fillable=['longitude','latitude','type','urlToImage','time','description','affichage'];
}
