<?php

namespace App\Console\Commands;

use App\DailyStat;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportUniqueNumbersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $sites = DailyStat::$sites;

        $data = [];

        foreach ($sites as $site) {
            $this->info("Fetching data of $site ... ");

            $telephone = $site === 'erosguiadb' ? 'telephone1' : 'telephone';
            $link = $site === 'erosguiadb' ? 'web' : 'link';
            $geo = DailyStat::$geoColumns[$site];

            $columns = [$telephone, $link, $geo];

            if ($site === 'pasiondb') array_push($columns, 'auto_renovados');

            $result = DB::connection('mysql2')->table($site)
                ->whereNotIn($telephone, ['0', '', '111'])
                ->where('status', 'active')
                ->get($columns);

            foreach ($result as $item){

                if (!isset($data[$item->$telephone])){
                    $data[$item->$telephone] = [
                        'links_count' => 0,
                        'geo' => '',
                        'auto_renovados' => 0,
                        'links' => [],
                    ];

                    if ($item->$geo !== '' && $data[$item->$telephone]['geo'] == ''){
                        $data[$item->$telephone]['geo'] = $item->$geo;
                    }
                }

                if ($site === 'pasiondb'){
                    $data[$item->$telephone]['auto_renovados'] += $item->auto_renovados;
                }

                $data[$item->$telephone]['links_count'] ++;
                array_push($data[$item->$telephone]['links'], $item->$link);
            }
        }

        $data = collect($data)
            ->sortByDesc('links_count');

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///
        ///                           Generating excel file
        ///
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->info('Generating excel file ... ');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValueByColumnAndRow(1,1, 'Exported on ' . Carbon::now()->toDateString());

        foreach (['Telephone', 'Geo','Links count', 'Autorenovados', 'Links'] as $index => $head)
            $sheet->setCellValueByColumnAndRow($index + 2 , 2, $head);

        $l = 3;

        foreach ($data as $telephone => $info){
            $sheet->setCellValueByColumnAndRow(2, $l, $telephone);
            $sheet->setCellValueByColumnAndRow(3, $l, $info['geo']);
            $sheet->setCellValueByColumnAndRow(4, $l, $info['links_count']);
            $sheet->setCellValueByColumnAndRow(5, $l, $info['auto_renovados']);

            foreach ($info['links'] as $i => $link)
                $sheet->setCellValueByColumnAndRow($i + 6, $l, $link);

            $l++;
        }

        $this->info('Writing to excel file ... ');

        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('storage/excel/unique-numbers.xlsx'));

    }
}
