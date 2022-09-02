<?php

namespace App;

use App\Traits\DailyStatQuery;
use Illuminate\Database\Eloquent\Model;

class DailyStat extends Model
{
    use DailyStatQuery;

    public static $sites = ['pasiondb', 'slumi', 'erosguiadb', 'mileroticos', 'mundosexanuncio', 'nuevoloquo', 'sexobarato', 'sustitutas', 'skokka',];

    public static $geoColumns = [
        'pasiondb' => 'geo',
        'slumi' => 'geo',
        'erosguiadb' => 'ciudad',
        'mileroticos' => 'addressRegion',
        'mundosexanuncio' => 'addressRegion',
        'nuevoloquo' => 'geo',
        'sexobarato' => 'geo',
        'sustitutas' => 'ciudad',
        'skokka' => 'provincia',
    ];

    public $timestamps = false;

    protected $casts = [
        'date' => 'date',
        'pasiondb' => 'json',
        'slumi' => 'json',
        'erosguiadb' => 'json',
        'mileroticos' => 'json',
        'mundosexanuncio' => 'json',
        'nuevoloquo' => 'json',
        'sexobarato' => 'json',
        'sustitutas' => 'json',
        'skokka' => 'json',
        'comparision' => 'json',
    ];
}

