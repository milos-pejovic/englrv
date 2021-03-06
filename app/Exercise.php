<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
use App\User;

class Exercise extends Model
{
    /**
     * 
     */
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * 
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
