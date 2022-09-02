<?php

namespace App\Http\Controllers;

use App\Ad;
use App\DailyStat;
use App\Post;
use App\Tariff;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Bitrix24Controller extends Controller
{
    static private $b24Hook = 'https://almejarosa.bitrix24.ru/rest/1/nitagufgcya8whoe/';

    public function __construct() {
        
    }

    public function addToBackList(Request $request)
    {
        $fields = $request->all();
        
        if(
            isset($fields['auth']['application_token'])
            && $fields['auth']['application_token'] == "tta6z7x68ftssruyo3xb94opoxybychc"
            && isset($fields['data']['FIELDS']['ID'])
        )
        {
            switch($fields['event'])
            {
                case 'ONCRMDEALUPDATE':

                    $dealId = $fields['data']['FIELDS']['ID'];
                    $dealData = self::getDeal($dealId);
                    
                    if(
                        sizeof($dealData) <= 0 
                        || !isset($dealData['STAGE_ID'])
                        || !isset($dealData['CONTACT_ID'])
                        || $dealData['STAGE_ID'] != "8"
                        || $dealData['CONTACT_ID'] <= 0
                    )
                        return true;

                    $contactData = self::getContact($dealData['CONTACT_ID']);
                    Log::channel('b24incoming')->info('', $contactData);
                    if(
                        sizeof($contactData) <= 0
                        || !isset($contactData['PHONE'])
                        || sizeof($contactData['PHONE']) <= 0
                        || !isset($contactData['PHONE'][0]['VALUE'])
                        || empty($contactData['PHONE'][0]['VALUE'])
                    )
                        return;
                    
                    $phone = $contactData['PHONE'][0]['VALUE'];
                    $phone = str_replace('+', '', $phone);
                    
                    if(
                        substr($phone, 0, 2) == '34'
                    )
                        $phone = substr($phone, 2, strlen($phone));
                        
                        
                    $phoneDb = DB::connection('mysql2')
                        ->table('blacklist_crm')
                        ->select('id')
                        ->where('telephone', $phone)
                        ->first();
                        
                    if($phoneDb)
                        return;
                        
                    $result = DB::connection('mysql2')
                        ->insert('insert into blacklist_crm (telephone) values (?)', [$phone]);

                    if($result)     
                        Log::channel('b24incoming')->info('Add phone to blacklist', [$result, $phone, $contactData['ID'], $dealData['ID']]);

                    break;
                default:
                    break;
            }
        }

        return true;
        
        Log::channel('b24incoming')->info('', $request->all());
    }

    static public function getDeal($id)
    {
        if($id > 0)
        {
            $response = Http::post(self::$b24Hook . 'crm.deal.get/', [
                'id' => $id
            ]);
            
            $response = $response->json();

            if(isset($response['result']) && sizeof($response['result']) > 0)
            {
                return $response['result'];
            }
        }

        return [];
    }

    static public function getContact($id)
    {
        if($id > 0)
        {
            $response = Http::post(self::$b24Hook . 'crm.contact.get/', [
                'id' => $id
            ]);
            
            $response = $response->json();

            if(isset($response['result']) && sizeof($response['result']) > 0)
            {
                return $response['result'];
            }
        }
        
        return [];
    }
}
