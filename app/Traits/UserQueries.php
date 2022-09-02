<?php

namespace App\Traits;

use App\DailyStat;
use App\User;

trait UserQueries
{
    public static function getRegisteredButNotPaid() {
        return User::whereDoesntHave('tariffs', function ($q) {
            $q->whereStatus('complete');
        });
    }

    public static function getPhoneVerifiedButNotPaid() {
        return self::getRegisteredButNotPaid()->whereNotNull('phone');
    }

    public static function getContinuedTariff() {
        $users = User::with([
            'tariffs' => function ($q) {
                $q->whereStatus('complete')->latest();
            }
        ])->get();

        $continued_users = 0;

        foreach ($users as $user){
            $tariffs = $user->tariffs->groupBy('post_id');

            $tariff = false;

            foreach ($tariffs as $t){
                if (count($t) > 1){
                    $tariff = true;
                    break;
                }
            }

            if ($tariff) $continued_users++;
        }

        return $continued_users;
    }

    public static function getChangedTariff() {
        $users = User::with([
            'tariffs' => function ($q) {
                $q->whereStatus('complete')->latest();
            }
        ])->get();

        $changed_users = 0;

        foreach ($users as $user){
            $tariffs = $user->tariffs->groupBy('post_id');

            $tariff = false;

            foreach ($tariffs as $t){
                $t = $t->pluck('name')->unique();

                if ($t->count() > 1){
                    $tariff = true;
                    break;
                }
            }

            if ($tariff) $changed_users++;
        }

        return $changed_users;
    }

    public static function getBoughtAnyTariff() {
        return User::whereHas('tariffs', function($q){
            $q->whereStatus('complete');
        })->count();
    }

    public static function getCalculationOfCities($sites) {
        $site = 'pasiondb';

        if ($sites[$site]->count() === 0){
            $max_ad = 0;
            $max_ad_name = '';

            foreach($sites as $key => $site){
                $geo = DailyStat::$geoColumns[$key];

                if ($site->where($geo, '!=', '')->count() > $max_ad){
                    $max_ad = $site->count();
                    $max_ad_name = $key;
                }
            }

            if ($max_ad !== 0){
                $site = $max_ad_name;
            }else{
                return ['', []];
            }
        }

        $cities = $sites[$site]->groupBy(DailyStat::$geoColumns[$site]);

        $all = count($sites[$site]);
        $result = [];

        foreach ($cities as $city => $ads) {
            array_push($result, [
                'city' => $city,
                'count' => count($ads),
                'percent' => (int) floor(count($ads) / $all * 100),
            ]);
        }

        return [$site, $result];
    }

    public static function getName($sites){
        $name = 'noname';

        foreach ($sites as $site){
            if (isset($site[0]->name)) $name = trim($site[0]->name);
        }

        return $name;
    }
}
