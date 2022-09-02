<?php

namespace App\Traits;

use App\Ad;
use App\DailyStat;
use Illuminate\Support\Collection;

trait AdQuery
{
    public static function getActualStatsEscortTrans() {
        $portals = DailyStat::orderByDesc('id')->first();

        $portals_escort_active = 0;
        $portals_escort_inactive = 0;
        $portals_trans_active = 0;
        $portals_trans_inactive = 0;

        foreach (DailyStat::$sites as $site) {
            $data = $portals->$site;

            $portals_escort_active += $data['active_escort'];
            $portals_escort_inactive += $data['inactive_escort'];
            $portals_trans_active += $data['active_trans'];
            $portals_trans_inactive += $data['inactive_trans'];
        }

        return [
            'portals_escort_active' => $portals_escort_active,
            'portals_escort_inactive' => $portals_escort_inactive,
            'portals_trans_active' => $portals_trans_active,
            'portals_trans_inactive' => $portals_trans_inactive,
        ];
    }

    public static function getTableBySites($parser, $ads) {
        $result = collect([]);

        /**@var Collection $ads */
        $links = collect([]);
        $parser_links = collect([]);

        foreach ($ads->flatten() as $ad){
            if ($ad->status !== 'active'){
                continue;
            }

            $links->push([
                'site' => $ad->site,
                'link' => $ad->link,
            ]);
        }

        foreach (Ad::sites_tables as $site => $table) {
            $parser_data = $table !== null && isset($parser[$table]) ? $parser[$table] : collect([]);

            foreach ($parser_data as $data) {
                if ($data->status !== 'active'){
                    continue;
                }

                $parser_links->push([
                    'site' => $site,
                    'link' => $data->link ?? 'https://www.erosguia.com/' . $data->site_id . '.html',
                ]);
            }

            $local_data = isset($ads[$site]) ? $ads[$site] : collect([]);

            $local_data_active = $local_data->where('status', 'active')->count();
            $local_data_inactive = $local_data->where('status', 'inactive')->count();
            $local_data = $local_data->count();

            $result->push([
                'site' => $site,
                'parser' => count($parser_data) !== 0 ? true : false,
                'parser_count' => count($parser_data),
                'active' => $local_data === 0 ? 0 : floor(($local_data_active / $local_data * 10000) / 100),
                'inactive' => $local_data === 0 ? 0 : floor(($local_data_inactive / $local_data * 10000) / 100),
                'active_count' => $local_data_active,
                'inactive_count' => $local_data_inactive,
                'total' => $local_data
            ]);
        }

        return [$result, $links, $parser_links];
    }
}
