<?php

namespace App\Console\Commands;

use App\DailyStat;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class NewStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make statistics of past day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $result = [];

        /*
         * pasiondb
         * */
        $this->info('pasiondb');

        $all = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('affiliation', 'contactos-mujeres')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'contactos-mujeres')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('affiliation', 'transexuales-travestis')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'transexuales-travestis')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $massage = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('affiliation', 'masajes-eroticos')
            ->where('telephone', '>', '0')
            ->count();

        $active_massage = DB::connection('mysql2')->table('pasiondb')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'masajes-eroticos')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_massage = $massage - $active_massage;

        $result['pasiondb'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans', 'active_massage', 'inactive_massage');

        /*
         * slumi
         * */
        $this->info('slumi');

        $all = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('affiliation', 'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('affiliation', 'travestis')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('slumi')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'travestis')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['slumi'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * erosguiadb
         * */
        $this->info('erosguiadb');

        $all = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('telephone1', '>', '0')->count();

        $active = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('status', 'active')->where('telephone1', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('affiliation','LIKE' ,'Escort%')
            ->where('telephone1', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('status', 'active')->where('affiliation','LIKE' ,'Escort%')
            ->where('telephone1', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('affiliation','LIKE', 'Travesti%')
            ->where('telephone1', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('erosguiadb')->distinct('telephone1')
            ->where('status', 'active')->where('affiliation', 'LIKE','Travesti%')
            ->where('telephone1', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['erosguiadb'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * mileroticos
         * */
        $this->info('mileroticos');

        $all = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('status', 'active')->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('affiliation', 'travestis')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('mileroticos')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','travestis')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['mileroticos'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * erosguiadb
         * */
        $this->info('mundosexanuncio');

        $all = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('affiliation','LIKE' ,'escorts%')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','LIKE' ,'escorts%')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('affiliation','LIKE', 'transexuales%')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('mundosexanuncio')->distinct('telephone')
            ->where('status', 'active')->where('affiliation', 'LIKE','transexuales%')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['mundosexanuncio'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * nuevoloquo
         * */
        $this->info('nuevoloquo');

        $all = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('affiliation' ,'escort')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('status', 'active')->where('affiliation' ,'escort')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('affiliation', 'travesti')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('nuevoloquo')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','travesti')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['nuevoloquo'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * sexobarato
         * */
        $this->info('sexobarato');

        $all = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('affiliation' ,'escort')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('status', 'active')->where('affiliation' ,'escort')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('affiliation', 'travesti')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('sexobarato')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','travesti')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['sexobarato'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * sustitutas
         * */
        $this->info('sustitutas');

        $all = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('status', 'active')->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('affiliation', 'travestis')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('sustitutas')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','travestis')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['sustitutas'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        /*
         * skokka
         * */
        $this->info('skokka');

        $all = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('telephone', '>', '0')->count();

        $active = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('status', 'active')->where('telephone', '>', '0')
            ->count();

        $inactive = $all - $active;

        $escorts = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $active_escort = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('status', 'active')->where('affiliation' ,'escorts')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_escort = $escorts - $active_escort;

        $trans = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('affiliation', 'travestis')
            ->where('telephone', '>', '0')
            ->count();

        $active_trans = DB::connection('mysql2')->table('skokka')->distinct('telephone')
            ->where('status', 'active')->where('affiliation','travestis')
            ->where('telephone', '>', '0')
            ->count();

        $inactive_trans = $trans - $active_trans;

        $result['skokka'] = compact('all', 'active', 'inactive', 'active_escort', 'inactive_escort', 'active_trans', 'inactive_trans');

        $comparison = $this->comparison();
        $comparison = ['escort' => count($comparison['escort']), 'trans' => count($comparison['trans'])];

        $daily_stat = new DailyStat();
        $daily_stat->date = Carbon::yesterday()->toDate();

        foreach (DailyStat::$sites as $site) {
            $daily_stat->$site = $result[$site];
        }

        $daily_stat->comparision = $comparison;

        $daily_stat->save();
    }


    public function comparison() {
        $this->info('comparision');

        // pasiondb
        $this->info("pasiondb...");

        $all = DB::connection('mysql2')->table('pasiondb')
            ->where('unixtime_check', '>', '0')
            ->whereNotIn('telephone', ['0', ''])
            ->groupBy('telephone')
            ->get(['status', 'affiliation', 'telephone']);

        foreach ($all as $item) {
            if ($item->affiliation == 'contactos-mujeres') {
                $comparision['escort'][$item->telephone] = 0;
            }
            if ($item->affiliation == 'transexuales-travestis') {
                $comparision['trans'][$item->telephone] = 0;
            }
        }

        // slumi
        $this->info("slumi...");

        $all = DB::connection('mysql2')->table('slumi')
            ->where('unixtime_check', '>', '0')
            ->whereNotIn('telephone', ['0', ''])
            ->groupBy('telephone')
            ->get(['status', 'affiliation', 'telephone']);

        foreach ($all as $item) {
            if ($item->affiliation == 'escorts') {
                $comparision['escort'][$item->telephone] = 0;
            }
            if ($item->affiliation == 'travestis') {
                $comparision['trans'][$item->telephone] = 0;
            }
        }

        // erosguiadb
        $this->info("erosguiadb...");

        $all = DB::connection('mysql2')->table('erosguiadb')
            ->where('unixtime_check', '>', '0')
            ->whereNotIn('telephone1', ['0', ''])
            ->groupBy('telephone1')
            ->get(['status', 'affiliation', 'telephone1']);

        foreach ($all as $item) {
            $category = explode(' ', $item->affiliation)[0];

            if ($category == 'Escort') {
                $comparision['escort'][$item->telephone1] = 0;
            }
            if ($category == 'Travesti') {
                $comparision['trans'][$item->telephone1] = 0;
            }
        }

//        // mileroticos
//        $this->info("mileroticos...");
//
//        $all = DB::connection('mysql2')->table('mileroticos')
//            ->where('unixtime_check', '>', '0')
//            ->whereNotIn('telephone', ['0', ''])
//            ->groupBy('telephone')
//            ->get(['status', 'affiliation', 'telephone']);
//
//        foreach ($all as $item) {
//            if ($item->affiliation == 'escorts') {
//                $comparision['escort'][$item->telephone] = 0;
//            }
//            if ($item->affiliation == 'travestis') {
//                $comparision['trans'][$item->telephone] = 0;
//            }
//        }
//
//        // mundosexanuncio
//        $this->info("mundosexanuncio...");
//
//        $all = DB::connection('mysql2')->table('mundosexanuncio')
//            ->where('unixtime_check', '>', '0')
//            ->whereNotIn('telephone', ['0', ''])
//            ->groupBy('telephone')
//            ->get(['status', 'affiliation', 'telephone']);
//
//        foreach ($all as $item) {
//            $category = explode('-', $item->affiliation)[0];
//
//            if ($category == 'escorts') {
//                $comparision['escort'][$item->telephone] = 0;
//
//            }
//            if ($category == 'transexuales') {
//                $comparision['trans'][$item->telephone] = 0;
//            }
//        }
//
//        // nuevoloquo
//        $this->info("nuevoloquo...");
//
//        $all = DB::connection('mysql2')->table('nuevoloquo')
//            ->where('unixtime_check', '>', '0')
//            ->whereNotIn('telephone', ['0', ''])
//            ->groupBy('telephone')
//            ->get(['status', 'affiliation', 'telephone']);
//
//        foreach ($all as $item) {
//            if ($item->affiliation == 'escort') {
//                $comparision['escort'][$item->telephone] = 0;
//            }
//            if ($item->affiliation == 'travesti') {
//                $comparision['trans'][$item->telephone] = 0;
//            }
//        }
//
//        // sexobarato
//        $this->info("sexobarato...");
//
//        $all = DB::connection('mysql2')->table('sexobarato')
//            ->where('unixtime_check', '>', '0')
//            ->whereNotIn('telephone', ['0', ''])
//            ->groupBy('telephone')
//            ->get(['status', 'affiliation', 'telephone']);
//
//        foreach ($all as $item) {
//            if ($item->affiliation == 'escort') {
//                $comparision['escort'][$item->telephone] = 0;
//            }
//            if ($item->affiliation == 'travesti') {
//                $comparision['trans'][$item->telephone] = 0;
//            }
//        }
//
        // sustitutas
        $this->info("sustitutas...");

        $all = DB::connection('mysql2')->table('sustitutas')
            ->where('unixtime_check', '>', '0')
            ->whereNotIn('telephone', ['0', ''])
            ->groupBy('telephone')
            ->get(['status', 'affiliation', 'telephone']);

        foreach ($all as $item) {
            if ($item->affiliation == 'escorts') {
                $comparision['escort'][$item->telephone] = 0;
            }
            if ($item->affiliation == 'travestis') {
                $comparision['trans'][$item->telephone] = 0;
            }
        }
//
//        // skokka
//        $this->info("skokka...");
//
//        $all = DB::connection('mysql2')->table('skokka')
//            ->where('unixtime_check', '>', '0')
//            ->whereNotIn('telephone', ['0', ''])
//            ->groupBy('telephone')
//            ->get(['status', 'affiliation', 'telephone']);
//
//        foreach ($all as $item) {
//            if ($item->affiliation == 'escorts') {
//                $comparision['escort'][$item->telephone] = 0;
//            }
//            if ($item->affiliation == 'travestis') {
//                $comparision['trans'][$item->telephone] = 0;
//            }
//        }

        return $comparision;
    }
}
