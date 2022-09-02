<?php

namespace App;

use App\Traits\PostQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use PostQueries;

    protected $guarded = [];

    public function tariffs() {
        return $this->hasMany(Tariff::class)->whereStatus('complete')->latest();
    }

    public function tariff() {
        return $this->hasOne(Tariff::class)->whereStatus('complete')->latest();
    }

    public function currentTariff() {
        if($this->id > 0)
            return \App\Tariff::where('post_id', $this->id)->where('status', '!=', 'wait')->latest();
        else
            return null;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function avatars() {
        return $this->hasMany(Avatar::class)->latest();
    }

    public function forums() {
        return $this->hasMany(Forum::class);
    }
}
