<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function childs()
    {
        return $this->hasMany('App\Service', 'parent');
    }
}
