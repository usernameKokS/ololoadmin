<?php

namespace App\Traits;

use App\Tariff;

trait TariffQuery
{
    public static function getPriceCalculations($start, $end, $isAll) {
        $tariffs = Tariff::whereStatus('complete');

        if ($isAll === 'false')
            $tariffs->whereBetween('start', [$start, $end]);


        $tariffs = $tariffs->get(['id', 'name', 'price']);

        $silver = $tariffs->where('name', 'silver')->pluck('price');
        $gold = $tariffs->where('name', 'gold')->pluck('price');
        $diamond = $tariffs->where('name', 'diamond')->pluck('price');

        return [
            'all' => [
                'sum' => $tariffs->pluck('price')->sum(),
                'count' => $tariffs->count(),
            ],

            'silver' => [
                'sum' => $silver->sum(),
                'count' => $silver->count(),
            ],

            'gold' => [
                'sum' => $gold->sum(),
                'count' => $gold->count(),
            ],

            'diamond' => [
                'sum' => $diamond->sum(),
                'count' => $diamond->count(),
            ],
        ];
    }
}
