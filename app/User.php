<?php

namespace App;

use App\Traits\UserQueries;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use UserQueries;

    protected $guarded = [];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function tariffs() {
        return $this->hasMany(Tariff::class)->whereStatus('complete');
    }

    public function ads() {
        return $this->hasMany(Post::class);
    }
}
