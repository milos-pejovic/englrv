<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exercise;

class Tag extends Model
{
    /**
     * 
     */
    public function exercizes() {
        return $this->belongsToMany('App/Exercise');
    }
}
