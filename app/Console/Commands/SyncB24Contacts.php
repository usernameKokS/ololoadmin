<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncB24Contacts extends Command
{
    static private $b24Hook = 'https://almejarosa.bitrix24.com/rest/1/r2u8j3ca8q55x176/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncb24:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync contacts between B24 and PasionDb';

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
        self::runExchange();
    }

    static public function runExchange($page = 0)
    {
        $phones = DB::connection('mysql2')
            ->table('pasiondb')
            ->select('id', 'name', 'telephone', 'status', 'unixtime_check')
            ->where('status', '!=', 'wait')
            ->whereBetween('telephone', ['600000000', '800000000'])
            ->orderBy('id', 'asc')
            ->limit(10)
            ->offset($page)
            ->get();

        $exchangeStart = false;
    
        foreach($phones as $phone)
        {   
            Log::channel('b24contacts')->info('Start!', (array)$phone);

            $contact = self::getContactByPhone($phone->telephone);

            switch($phone->status)
            {
                case 'inactive':

                    Log::channel('b24contacts')->info('Contact inactive');

                    if(!$contact)
                    {
                        Log::channel('b24contacts')->info('Contact is no exists!');
                        continue 2;
                    }

                    $contactId = $contact['ID'];
                    
                    $deals = self::getDeals([
                        'CONTACT_ID' => $contactId,
                        'CLOSED' => 'N'
                        // 'CATEGORY_ID' => 0
                    ]);

                    if(sizeof($deals) > 0)
                    {
                        foreach($deals as $deal)
                            self::dealRemoveByDealId($deal['ID']);
                    }
                    else
                    {
                        Log::channel('b24contacts')->info('Deals is not exists!');
                    }

                    break;
                case 'active':

                    Log::channel('b24contacts')->info('Contact active');

                    if(!$contact)
                        $contactId = self::contactAdd($phone);
                    else
                        $contactId = $contact['ID'];

                    $deals = self::getDeals([
                        'CONTACT_ID' => $contactId,
                        // 'CLOSED' => 'N'
                        // 'CATEGORY_ID' => 0
                    ]);

                    if(sizeof($deals) <= 0)
                    {
                        self::dealAdd([
                            'fields' => [
                                "TITLE" => (strlen($phone->name) > 0 ? $phone->name : $phone->telephone), 
                                "STAGE_ID" => "NEW", 					
                                "CONTACT_ID" => $contactId,
                                "OPENED" => "Y", 
                                "ASSIGNED_BY_ID" => 1,
                                "CATEGORY_ID" => 0
                            ]
                        ]);
                    }
                    else
                    {
                        Log::channel('b24contacts')->info('Deals is exists!');
                    }

                    break;
                default: break;
            }

            $exchangeStart = true;
            Log::channel('b24contacts')->info('End!');
        }

        
        if($exchangeStart)
        {
            $page++;
            Log::channel('b24contacts')->info('Next page: ' . $page);
            self::runExchange($page);
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
            Log::channel('b24contacts')->info('Deal add success: ' . $response['result']);
        }
        else
        {
            Log::channel('b24contacts')->warning('Warning: Deal add', $response);
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
            Log::channel('b24contacts')->info('Deal remove success: ' . $dealId);
        }
        else
        {
            Log::channel('b24contacts')->warning('Warning: Deal remove', $response);
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
                Log::channel('b24contacts')->warning('Warning: Deals add', $response);
            }
        }

        return [];
    }   

    static public function contactAdd($fields)
    {
        $requestData = [
            'fields' => [
                "NAME" => strlen($fields->name) > 0 ? $fields->name : $fields->telephone, 
                "OPENED" => "Y", 
                "ASSIGNED_BY_ID" => 1, 
                "TYPE_ID" => "CLIENT",
                "SOURCE_ID" => "SELF",
                "PHONE" => [
                    ["VALUE" => $fields->telephone, "VALUE_TYPE" => "MOBILE"]
                ]
            ]
        ];

        $response = Http::post(self::$b24Hook . 'crm.contact.add/', $requestData);
        $response = $response->json();

        if(isset($response['result']) && $response['result'] > 0)
        {
            Log::channel('b24contacts')->info('Contact add success: ' . $response['result']);
            return $response['result'];
        }
        else
        {
            Log::channel('b24contacts')->warning('Warning: Contact add', $response);
            return 0;
        }
    }

    static public function getContactByPhone($phone)
    {
        if($phone > 0)
        {
            $response = Http::post(self::$b24Hook . 'crm.contact.list/', [
                'filter' => [
                    'PHONE' => $phone
                ]
            ]);
            
            $response = $response->json();

            if(isset($response['total']) && $response['total'] > 0)
            {
                return $response['result'][0];
            }
            elseif(!isset($response['total']))
            {
                Log::channel('b24contacts')->warning('Warning: Contact get', $response);
            }
        }
        
        return false;
    }
}
