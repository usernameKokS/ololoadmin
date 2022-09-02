<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncB24Registered extends Command
{
    static private $b24Hook = 'https://almejarosa.bitrix24.ru/rest/1/nitagufgcya8whoe/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncb24:registered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync registered of contacts between B24 and Almejarosa.Es';

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
    static public function handle()
    {
        // SELECT id, NAME, phone FROM posts WHERE id>193 AND phone IS NOT NULL AND end_pay IS null;
        $posts = \App\Post::where('id', '>', 193)
            ->whereNotNull('phone')
            ->whereNull('end_pay')
            ->whereBetween('created_at', [\Carbon\Carbon::now()->subDays(1),\Carbon\Carbon::now()])
            // ->where('status', 'creating')
            ->get();

        $index = 0;

        $categoryId = 0;

        foreach($posts as $post)
        {
            $phoneDb = DB::connection('mysql2')
                ->table('blacklist_crm')
                ->select('id')
                ->where('telephone', $post->phone)
                ->first();
                
            if($phoneDb)
                continue;

            Log::channel('b24registered')->info('Start!', (array)$post->id);

            $contact = self::getContactByPhone($post->phone);

            if(!$contact)
                $contactId = self::contactAdd($post);
            else
                $contactId = $contact['ID'];

            $deals = self::getDeals([
                'CONTACT_ID' => $contactId,
                'CLOSED' => 'N'
                // 'CATEGORY_ID' => 0
            ]);
            
            // $stageId = 'C'.$categoryId.':NEW';
            $stageId = 'NEW';
            // phone saved
            if($post->status == 'creating')
                $stageId = 'PREPAYMENT_INVOICE'; //$stageId = 'C'.$categoryId.':PREPARATION';
            // ad saved
            else if($post->status == 'create')
                $stageId = 'EXECUTING'; //$stageId = 'C'.$categoryId.':PREPAYMENT_INVOICE';

            if(sizeof($deals) <= 0)
            {
                self::dealAdd([
                    'fields' => [
                        "TITLE" => (strlen($post->name) > 0 ? $post->name : $post->phone), 
                        "STAGE_ID" => $stageId, 					
                        "CONTACT_ID" => $contactId,
                        "OPENED" => "Y", 
                        "ASSIGNED_BY_ID" => 1,
                        "CATEGORY_ID" => $categoryId
                    ]
                ]);
            }
            else
            {
                if($deals[0]['CATEGORY_ID'] != '0')
                {
                    self::dealRemoveByDealId($deals[0]['ID']);
                    self::dealAdd([
                        'fields' => [
                            "TITLE" => (strlen($post->name) > 0 ? $post->name : $post->phone), 
                            "STAGE_ID" => $stageId, 					
                            "CONTACT_ID" => $contactId,
                            "OPENED" => "Y", 
                            "ASSIGNED_BY_ID" => 1,
                            "CATEGORY_ID" => $categoryId
                        ]
                    ]);
                }
            }

            if($index == 5)
            {
                $index = 0;
                sleep(3);
            }
            else
                $index++;
        }
    }

    static public function dealRemoveByDealId($dealId)
    {
        if($dealId <= 0)
            return false;

        $response = Http::post(self::$b24Hook . 'crm.deal.delete/', [
            'id' => $dealId
        ]);
        
        $response = $response->json();

        if(isset($response['result']) && $response['result'] === true)
        {
            Log::channel('b24registered')->info('Deal remove success: ' . $dealId);
        }
        else
        {
            Log::channel('b24registered')->warning('Warning: Deal remove', $response);
        }
    }

    static public function dealUpdate($fields)
    {
        if(
            !is_array($fields) 
            || sizeof($fields) <= 0
            || (int)($fields['id']) <= 0
        )
        {
            Log::channel('b24registered')->info('dealUpdate error', $fields);
            return false;
        }
            

        $response = Http::post(self::$b24Hook . 'crm.deal.update/', $fields);
        
        $response = $response->json();
        
        if(isset($response['result']) && $response['result'] > 0)
        {
            Log::channel('b24registered')->info('Deal update success: ' , $fields);
        }
        else
        {
            Log::channel('b24registered')->warning('Warning: Deal update', $response);
        }
    }

    static public function dealAdd($fields)
    {
        if(!is_array($fields) || sizeof($fields) <= 0)
            return false;

        $response = Http::post(self::$b24Hook . 'crm.deal.add/', $fields);
        
        $response = $response->json();
        
        if(isset($response['result']) && $response['result'] > 0)
        {
            Log::channel('b24registered')->info('Deal add success: ' . $response['result']);
        }
        else
        {
            Log::channel('b24registered')->warning('Warning: Deal add', $response);
        }
    }

    static public function getDeals($filter)
    {
        if($filter['CONTACT_ID'] > 0)
        {
            $response = Http::post(self::$b24Hook . 'crm.deal.list/', [
                'filter' => $filter
            ]);
            
            $response = $response->json();

            if(isset($response['total']) && $response['total'] > 0)
            {
                return $response['result'];
            }
            elseif(!isset($response['total']))
            {
                Log::channel('b24registered')->warning('Warning: Deals add', $response);
            }
        }

        return [];
    }   

    static public function contactAdd($fields)
    {
        $requestData = [
            'fields' => [
                "NAME" => strlen($fields->name) > 0 ? $fields->name : $fields->phone, 
                "OPENED" => "Y", 
                "ASSIGNED_BY_ID" => 1, 
                "TYPE_ID" => "CLIENT",
                "SOURCE_ID" => "SELF",
                "PHONE" => [
                    ["VALUE" => '34' . $fields->phone, "VALUE_TYPE" => "MOBILE"]
                ]
            ]
        ];

        $response = Http::post(self::$b24Hook . 'crm.contact.add/', $requestData);
        $response = $response->json();

        if(isset($response['result']) && $response['result'] > 0)
        {
            Log::channel('b24registered')->info('Contact add success: ' . $response['result']);
            return $response['result'];
        }
        else
        {
            Log::channel('b24registered')->warning('Warning: Contact add', $response);
            return 0;
        }
    }

    static public function getContactByPhone($phone)
    {
        if($phone > 0)
        {
            $response = Http::post(self::$b24Hook . 'crm.contact.list/', [
                'filter' => [
                    'PHONE' => '34'.$phone
                ]
            ]);
            
            $response = $response->json();

            if(isset($response['total']) && $response['total'] > 0)
            {
                return $response['result'][0];
            }
            elseif(!isset($response['total']))
            {
                Log::channel('b24registered')->warning('Warning: Contact get', $response);
            }
        }
        
        return false;
    }
}
