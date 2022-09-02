<?php

namespace App\Http\Controllers;

use App\Ad;
use App\DailyStat;
use App\Post;
use App\Tariff;
use App\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function test()
    {
        // \App\Console\Commands\SyncB24Contacts::handle();
        \App\Console\Commands\SyncB24Registered::handle();
    }

    public function index() {
        $sites = collect(DailyStat::$sites);

        return view('pages.home', compact('sites'));
    }

    public function general_stats() {
        $posts = Post::getAllPosts()->get(['id', 'end_pay']);

        return $this->responseJson('Success', 200, [
            'all' => count($posts),
            'active' => Post::getActivePostsCount($posts),
            'nonActive' => count($posts) - Post::getActivePostsCount($posts),
            'registeredButNotPaid' => User::getRegisteredButNotPaid()->count(),
        ]);
    }

    public function escort_trans() {
        $posts = Post::getPostsCategoryWithItsEntity();

        $escort = $posts->where('entity', 0)->where('category', 'Escort')->count();
        $trans = $posts->where('entity', 0)->where('category', 'Travesti')->count();
        $escort_club = $posts->where('entity', 1)->where('category', 'Escort')->count();
        $trans_club = $posts->where('entity', 1)->where('category', 'Travesti')->count();

        return $this->responseJson('Success', 200, compact('escort', 'trans', 'escort_club', 'trans_club'));
    }

    public function user_stats() {
        return $this->responseJson('Success', 200, [
            'phoneVerifiedButNotPaid' => User::getPhoneVerifiedButNotPaid()->count(),
            'boughtAnyTariff' => User::getBoughtAnyTariff(),
            'tariffContinued' => User::getContinuedTariff(),
            'tariffChanged' => User::getChangedTariff(),
        ]);
    }

    public function tariff() {
        $range = explode(' - ', request('range'));
        $isAll = request('isAll');

        return $this->responseJson('Success', 200, Tariff::getPriceCalculations(
            Carbon::createFromTimestamp($range[0])->addDay()->toDate()->setTime(0,0,0),
            Carbon::createFromTimestamp($range[1])->addDay()->toDate()->setTime(23,59,59),
            $isAll
        ));
    }

    public function accounts() {
        $range = explode(' - ', request('range'));

        $start = Carbon::createFromTimestamp($range[0])->toDate();
        $end = Carbon::createFromTimestamp($range[1])->addDay()->toDate();

        $stats = DailyStat::where('date', '>=', $start)->where('date', '<=', $end)->get();
        $actualStats = DailyStat::orderByDesc('id')->first();
        $actualStatsTotal = Ad::getActualStatsEscortTrans();

        return $this->responseJson('Success', 200, compact('stats', 'actualStats', 'actualStatsTotal'));
    }

    public function ads_table() {
        $ads = Ad::where('status', '!=', 'delete')->get();
        $sites = collect(Ad::sites);

        $result = [];

        $all = $ads->count();
        $count = $sites->count();
        $total_active_count = $ads->where('status', 'active')->count();
        $total_inactive_count = $ads->where('status', 'inactive')->count();
        $total_active = floor($total_active_count / $all * 100 * 100) / 100;
        $total_inactive = floor($total_inactive_count / $all * 100 * 100) / 100;

        $result['all'] =
            compact('all', 'count', 'total_active', 'total_inactive', 'total_active_count', 'total_inactive_count');

        foreach ($sites as $site) {
            $current = $ads->where('site', $site);
            $all = $current->count() === 0 ? 1 : $current->count();
            $active = $current->where('status', 'active')->count();
            $inactive = $current->where('status', 'inactive')->count();

            $result['sites'][$site] = [
                'total' => $current->count(),
                'total_active' => floor(($active / $all) * 10000) / 100,
                'total_inactive' => floor(($inactive / $all) * 10000) / 100,
                'total_active_count' => $active,
                'total_inactive_count' => $inactive,
            ];
        }

        $result = collect($result);

        return $this->responseJson('Success', 200, $result);
    }

    public function comparison() {
        return $this->responseJson('Success', 200, DailyStat::getComparisonOfTwoPortals());
    }
}
