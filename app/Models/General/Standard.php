<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    protected $guarded = [];

    public function childs() {
        return $this->hasMany('App\Models\General\Standard','parent_id','id') ;
    }
}
