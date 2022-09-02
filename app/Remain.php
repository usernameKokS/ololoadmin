<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remain extends Model
{
    public function childs()
    {
        return $this->hasMany('App\Remain', 'parent');
    }

}