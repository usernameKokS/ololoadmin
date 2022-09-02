<?php

namespace App;

use App\Traits\TariffQuery;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use TariffQuery;

    protected $guarded = [];
}
