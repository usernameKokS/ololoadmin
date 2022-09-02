<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avatar;
use App\Category;
use App\Post;
use App\Video;
use App\Rate;
use App\Service;
use App\Remain;
use App\Place;
use App\Tariff;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ToVerifyController extends Controller
{
    public function index()
    {
        $list = [];
        $tariffs = \App\Tariff::whereNotNull('to_verify_at')->orderBy('to_verify_at', 'asc')->get();

        if(sizeof($tariffs) > 0)
        {
            $postIds = array_column($tariffs->toArray(), 'post_id');
            $list = \App\Post::whereIn('id', $postIds)->get();
        }

        return view("pages.to_verify.list", compact('list'));
    }

    public function detail($id)
    {
        $cats = \App\Category::orderBy('title')->distinct('title')->pluck('title');
        //$user = Auth::user();

        // $post = Post::where('user_id', $user->id)->where('id', $id)->latest()->first();

        $post = Post::where('id', $id)->where('is_delete', 0)->latest()->first();
        
        if(!$post){
            abort(404);
        }

        $rates = Rate::where('post_id', $post->id)->get();

        $services = Service::where('post_id', $post->id)->with('childs')->get();

        $remains = Remain::where('post_id', $post->id)->with('childs')->get();

        $places = Place::where('string', '!=', null)->where('province', '!=', null)->where('town', '!=', null)->get();
        
        $post->catsPasion = $post->category;

		$post->tarifa = 'No';
		$tarif = Tariff::where('status', '!=', 'wait')
		->where('post_id', $post->id)
		->where('user_id', $post->user_id)->latest()->first();

		if($tarif){
			$post->end_pay = $tarif->end;
			if(Carbon::parse($tarif->end)->timestamp > Carbon::now()->timestamp){
				$post->tarifa = $tarif['name'];
            }
            
            if(!empty($tarif->pasion_category))
                $post->catsPasion = $tarif->pasion_category;
		}
        
        $user = \App\User::where('id', $post->user_id)->first();

        $currentTariffs = [
            'sustitutas' => 'verif',
            'erosguia' => 'verif',
            'mileroticos' => 'verif',
            'adultguia' => 'verif',
            'nuevoloquo' => 'verif',
            'slumi' => 'verif'
        ];

        if($tarif)
        {
            if(strlen($tarif->sustitutas_status) > 0)
                $currentTariffs['sustitutas'] = $tarif->sustitutas_status;

            if(strlen($tarif->erosguia_status) > 0)
                $currentTariffs['erosguia'] = $tarif->erosguia_status;

            if(strlen($tarif->mileroticos_status) > 0)
                $currentTariffs['mileroticos'] = $tarif->mileroticos_status;

            if(strlen($tarif->adultguia_status) > 0)
                $currentTariffs['adultguia'] = $tarif->adultguia_status;

            if(strlen($tarif->nuevoloquo_status) > 0)
                $currentTariffs['nuevoloquo'] = $tarif->nuevoloquo_status;
            
            if(strlen($tarif->slumi_status) > 0)
                $currentTariffs['slumi'] = $tarif->slumi_status;
        }

        $statuses = [];
        $list = \App\DescriptionStatus::get();

        if($list)
            $statuses = $list;

        $catsPasion = $cats->toArray();
        $catsPasion[] = 'Webcam';

        return view('pages.to_verify.detail', compact('user', 'cats', 'catsPasion', 'post', 'rates', 'services', 'remains', 'places', 'statuses', 'currentTariffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'province' => ['required'],
            'town' => ['required'],
            'place' => ['required'],
            'post_id' => ['required'],
            'worktime' => ['required'],
            'category' => ['required'],
            'title' => ['required'],
            // 'text' => ['required'],
            'name' => ['required'],
            'age' => ['required'],
        ]);

        $post = Post::where('is_delete', 0)
        ->where('id', $request['post_id'])
        ->latest()
        ->first();
        
        $user = \App\User::whereId($post->user_id)->first();

        $avatar = Avatar::where('post_id', $request['post_id'])->count();
		if(!$avatar || $avatar < 3)
		{
			return response()->json([
				'message' => 'Como mínimo tienes que subir 3 fotos.',
				'type' => 'error'
			]);
		}
		
		if(
			empty(trim($request['text_1']))
			|| empty(trim($request['text_2']))
			|| empty(trim($request['text_3']))
			|| empty(trim($request['text_4']))
			|| empty(trim($request['text_5']))
			|| empty(trim($request['text_6']))
			|| empty(trim($request['text_7']))
			|| empty(trim($request['text_8']))
			|| empty(trim($request['text_9']))
			|| empty(trim($request['text_10']))
		)
		{
			return response()->json([
				'message' => 'Descripción tiene que ser mínimo de 300 y máximo de 1000 dígitos en las 10 líneas.',
				'type' => 'error'
			]);
		}
		
        if(
            $request['edit'] == 'true' 
            && $post->status == 'create'
        )
        {
            /*if(!$post->tariffSetOneEdit())
                return 'Error';*/

            // $post->modificar = 1;
        }

        $post->town = $request['town'];
        $post->province = $request['province'];
        $post->place = $request['place'];
        $post->zona = $request['zona'];

        $post->map = $request['currentPlace'];

        $post->status = 'create';
        $post->category = $request['category'];
        $post->title = $request['title'];
        $post->text = join('###', [
			$request['text_1'],
			$request['text_2'],
			$request['text_3'],
			$request['text_4'],
			$request['text_5'],
			$request['text_6'],
			$request['text_7'],
			$request['text_8'],
			$request['text_9'],
			$request['text_10']
		]);
        $post->name = $request['name'];
        $post->age = $request['age'];
        $post->whatsapp = $request['whatsapp'];
        $post->worktime = $request['worktime'];
        $post->save();

        $old_rates = Rate::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->get();

        foreach ($old_rates as $old_rate) {
            Rate::where('id', $old_rate['id'])->delete();
        }

        $old_services = Service::where('post_id', $post->id)
            ->get();

        foreach ($old_services as $old_service) {
            Service::where('id', $old_service['id'])->delete();
        }

        $old_remains = Remain::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->get();

        foreach ($old_remains as $old_remain) {
            Remain::where('id', $old_remain['id'])->delete();
        }


        if (count($request['rates']) > 0) {
            foreach ($request['rates'] as $rate) {
                $new_rate = new Rate;
                $new_rate->user_id = $user->id;
                $new_rate->post_id = $post->id;
                $new_rate->title = $rate['title'];
                $new_rate->price = $rate['price'];
                $new_rate->save();
            }
        }

        if (isset($request['services']) && count($request['services']) > 0) {
            foreach ($request['services'] as $rate) {

                if ($rate['active'] == true) {
                    if(($rate['name'] == 'activas') or ($rate['name'] == 'pasivas')){
                        if($post->category == 'Travesti'){
                            $new_rate = new Service;
                            $new_rate->user_id = $user->id;
                            $new_rate->post_id = $post->id;
                            $new_rate->name = $rate['name'];
                            $new_rate->save();
                        }
                    } else {
                        $new_rate = new Service;
                        $new_rate->user_id = $user->id;
                        $new_rate->post_id = $post->id;
                        $new_rate->name = $rate['name'];
                        $new_rate->save();
                    }

                }

                // if (count($rate['options']) > 0) {

                    foreach ($rate['options'] as $minoption) {
                        if ($minoption['active'] == true) {
                            $new_serv = new Service;
                            $new_serv->user_id = $user->id;
                            $new_serv->post_id = $post->id;
                            $new_serv->parent = $new_rate->id;
                            $new_serv->name = $minoption['name'];
                            $new_serv->save();
                        }
                    }
                // }
            }
        }

        if (isset($request['sobres']) && count($request['sobres']) > 0) {
            foreach ($request['sobres'] as $rate) {
                if ($rate['active'] == true) {
                    $new_rate = new Remain;
                    $new_rate->user_id = $user->id;
                    $new_rate->post_id = $post->id;
                    $new_rate->name = $rate['name'];
                    $new_rate->save();
                }

                if (count($rate['options']) > 0) {

                    foreach ($rate['options'] as $minoption) {
                        if ($minoption['active'] == true) {
                            $new_serv = new Remain;
                            $new_serv->user_id = $user->id;
                            $new_serv->post_id = $post->id;
                            $new_serv->parent = $new_rate->id;
                            $new_serv->name = $minoption['name'];
                            $new_serv->save();
                        }
                    }
                }
            }
        }

        $tariff = $post->currentTariff()->first();
        
        if($tariff)
        {
            if(isset($request['erosguia']))
                $tariff->erosguia_status = $request['erosguia'];
            else 
                $tariff->erosguia_status = 'verif';

            if(isset($request['sustitutas']))
                $tariff->sustitutas_status = $request['sustitutas'];
            else
                $tariff->sustitutas_status = 'verif';
            
            if(isset($request['mileroticos']))
                $tariff->mileroticos_status = $request['mileroticos'];
            else
                $tariff->mileroticos_status = 'verif';

            if(isset($request['adultguia']))
                $tariff->adultguia_status = $request['adultguia'];
            else
                $tariff->adultguia_status = 'verif';

            if(isset($request['nuevoloquo']))
                $tariff->nuevoloquo_status = $request['nuevoloquo'];
            else
                $tariff->nuevoloquo_status = 'verif';

            if(isset($request['slumi']))
                $tariff->slumi_status = $request['slumi'];
            else
                $tariff->slumi_status = 'verif';
                
            if(isset($request['categorypasion']))
                $tariff->pasion_category = $request['categorypasion'];

            $tariff->save();
        }

        return 'Success';
    }

    public function toApprove(Request $request)
    {
        $post = Post::where('is_delete', 0)
            ->where('id', $request['post_id'])
            ->latest()
            ->first();

        if($post)
        {
            $tariff = $post->currentTariff()->first();

            if($tariff)
            {
                $tariff->to_verify_at = null;

                if($tariff->status == 'create')
                {
                    $tariff->status = 'complete';

                    $nowDate = \Carbon\Carbon::now();
                    $currentTariffStartDate = \Carbon\Carbon::parse($tariff->start);
                    $currentTariffEndDate = \Carbon\Carbon::parse($tariff->end);

                    $diffInMinutes = $currentTariffStartDate->diffInMinutes($nowDate);

                    if($diffInMinutes > 0)
                        $currentTariffEndDate->addMinutes($diffInMinutes);
            
                    $tariff->start = $nowDate;
                    $tariff->end = $currentTariffEndDate;
                }
                else
                {
                    $tariff->modificar = 1;
                    $tariff->edit = 1;
                    $tariff->status = 'modificar';
                }
                
                $tariff->save();
            }
        }
    }
}
