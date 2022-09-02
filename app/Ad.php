<?php

namespace App;

use App\Traits\AdQuery;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use AdQuery;

    const sites = [
        'Pasion.com',
        'Mundosexanuncio.com',
        'Slumi.com',
        'Coneroticas.com',
        'Sexobarato.es',
        'Hott.es',
        'Adultguia.com',
        'Destacamos.com',
        'Milanunciosex.com',
        'Escortpasion.com',
        'Eurogirlsescort.com',
        'Sexoyrelax.com',
        'Eanuncios.com',
        'Mundoanuncioerotico.com',
        'Erosguia.com',
        'Nuevoloquo.com',
        'Sustitutas.com',
        'Skokka.com',
        'Mileroticos.com'
    ];

    const sites_tables = [
        'Pasion.com' => 'pasiondb',
        'Mundosexanuncio.com' => 'mundosexanuncio',
        'Slumi.com' => 'slumi',
        'Coneroticas.com' => null,
        'Sexobarato.es' => 'sexobarato',
        'Hott.es' => null,
        'Adultguia.com' => null,
        'Destacamos.com' => null,
        'Milanunciosex.com' => null,
        'Escortpasion.com' => null,
        'Eurogirlsescort.com' => null,
        'Sexoyrelax.com' => null,
        'Eanuncios.com' => null,
        'Mundoanuncioerotico.com' => null,
        'Erosguia.com' => 'erosguiadb',
        'Nuevoloquo.com' => 'nuevoloquo',
        'Sustitutas.com' => 'sustitutas',
        'Skokka.com' => 'skokka',
        'Mileroticos.com' => 'mileroticos',
    ];
}
