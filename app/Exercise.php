<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;

class Exercise extends Model
{
    /**
     * 
     */
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
