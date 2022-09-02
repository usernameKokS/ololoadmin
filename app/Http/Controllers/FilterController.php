<?php

namespace App\Http\Controllers;

use App\DailyStat;
use Cache;
use DB;

class FilterController extends Controller
{
    public function index() {
        $sites = collect(DailyStat::$sites);
        $cities = DailyStat::getCitiesOfTable('pasiondb');

        return view('pages.filter', compact('sites', 'cities'));
    }

    public function getCities($table) {
        return $this->responseJson('Success', 200, DailyStat::getCitiesOfTable($table));
    }

    public function getTable($table, $city) {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        set_time_limit(-1);

        $cache_name = implode('.', [$table, $city]);
        if (Cache::has($cache_name))
            return $this->responseJson('Success', 200, Cache::get($cache_name));

        // Получить имя столбца, в котором находится гео пользователя
        $column = DailyStat::$geoColumns[$table];

        $telephone = $table === 'erosguiadb' ? 'telephone1' : 'telephone';

        // Если город тодос, то показать все
        $city = $city === 'Todos' ? '%%' : "%$city%";

        // Если таблица является erosguiadb, тогда возьмите колонку web
        $link = $table === 'erosguiadb' ? 'web' : 'link';

        $columns = [$telephone, $column, $link];

        // Если таблица pasion, то возьмите также auto_renovados
        if ($table === 'pasiondb') {
            array_push($columns, 'auto_renovados');
        }

        $t = $table;

        $table = DB::connection('mysql2')->table($table)
            ->whereNotIn($telephone, ['0', ''])
            ->whereNotIn($column, [''])
            ->where($column, 'LIKE', $city)
            ->where('status', 'active')
            ->get($columns)
            ->groupBy($telephone)
            ->toArray();

        $table = DailyStat::uasort($table);

        $data = collect([]);

        foreach ($table as $number => $ads){
            $links = collect([]);
            foreach ($ads as $ad) $links->push([
                'link' => $ad->$link,
                'auto_renovados' => $t === 'pasiondb' ? $ad->auto_renovados : 0,
            ]);

            $data->push([
                'telephone' => $number,
                'links' => $links,
                'auto_renovados' => $t === 'pasiondb' ? collect($ads)->sum('auto_renovados') : 0,
                'links_count' => $links->count(),
            ]);
        }

        Cache::put($cache_name, $data, 24 * 60 * 60);

        return $this->responseJson('Success', 200, $data);
    }
}
