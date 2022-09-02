<?php

namespace App\Traits;

use App\DailyStat;
use App\Post;
use DB;

trait DailyStatQuery
{
    public static function getComparisonOfTwoPortals() {
        $portals = DailyStat::orderByDesc('id')->first(['id', 'comparision'])->comparision;
        $almejarosa = Post::whereIn('category', ['Escort', 'Travesti'])->get('category');

        $pe = $portals['escort'];
        $pt = $portals['trans'];

        $ae = $almejarosa->where('category', 'Escort')->count();
        $at = $almejarosa->where('category', 'Travesti')->count();

        return compact('pe', 'pt', 'ae', 'at');
    }

    public static function getSitesByTelephone($telephone) {
        $sites = [];
        $notEmptySitesCount = 0;

        foreach (DailyStat::$sites as $site) {
            $field = $site === 'erosguiadb' ? 'telephone1' : 'telephone';
            $data = DB::connection('mysql2')->table($site)->where($field, $telephone)->get();
            $sites[$site] = $data;

            if ($data->count() !== 0) $notEmptySitesCount++;
        }

        $auto_renovados = 0;

        foreach ($sites['pasiondb'] as $ad) $auto_renovados += $ad->auto_renovados;

        return [$sites, $notEmptySitesCount, $auto_renovados];
    }

    public static function getCitiesOfTable($table) {
        $column = DailyStat::$geoColumns[$table];

        return collect('Todos')->merge(
            DB::connection('mysql2')->table($table)
                ->groupBy($column)->whereNotNull($column)
                ->get($column)->pluck($column)
        );
    }

    public static function getAvatarsFromParser($telephone) {
        $site_ids = DB::connection('mysql2')->table('erosguiadb')
            ->where('telephone1', $telephone)->get('site_id')->pluck('site_id');

        $erosguia_photos = DB::connection('mysql2')->table('erosguia_photos')
            ->whereIn('site_id', $site_ids)->get(['site_id', 'name'])
            ->map(function ($photo) {
                return "http://80.89.235.102/1/$photo->site_id/$photo->name";
            });

        $site_ids = DB::connection('mysql2')->table('pasiondb')
            ->where('telephone', $telephone)->get('site_id')->pluck('site_id');

        $pasion_photos = DB::connection('mysql2')->table('pasion_photos')
            ->whereIn('site_id', $site_ids)->get(['site_id', 'name'])
            ->map(function ($photo) {
                return "http://80.89.235.102/2/$photo->site_id/$photo->name";
            });

        return $erosguia_photos->merge($pasion_photos);
    }

    public static function uasort($data) {
        uasort($data, function ($a, $b) {
            $a = count($a);
            $b = count($b);

            return ($a == $b) ? 0 : (($a > $b) ? -1 : 1);
        });

        return $data;
    }
}
