<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Avatar;
use App\DailyStat;
use App\Post;
use App\Tariff;
use App\User;
use Carbon\Carbon;
use DB;

class ProfileController extends Controller
{
    public function profile($telephone) {
        $post = Post::wherePhone($telephone)
            ->with(['user.posts.avatars', 'user.tariffs', 'avatars', 'forums'])
            ->withCount(['user'])->first();

        if (!$post) {
            return redirect(route('profileOnlyParser', $telephone));
        }


        [$sites, $notEmptySitesCount, $auto_renovados] = DailyStat::getSitesByTelephone($telephone);

        $profile = collect([
            'name' => $post->name,
            'email' => $post->user->email,
            'tel' => $telephone,
            'posts_count' => count($post->user->posts),
            'tariffs_count' => count($post->user->tariffs),
            'tariffs_sum' => $post->user->tariffs->pluck('price')->sum(),
            'portals_count' => $notEmptySitesCount,
            'auto_renovados' => $auto_renovados,
            'auto_renovados_sum' => $auto_renovados * 0.2,
            'avatars' => Avatar::getAbsolutePathOfAvatars($post->avatars->pluck('url')),
        ]);

        [$site, $cities] = User::getCalculationOfCities($sites);

        $cities = collect([
            'site' => $site,
            'cities' => collect($cities),
        ]);

        $settings = collect([
            'entity' => $post->user->entity,
            'blocked' => $post->user->blocked,
            'end_pay' => $post->end_pay,
        ]);

        $parser_data = collect($sites);
        $local_data = Ad::wherePostId($post->id)->get()->groupBy('site');
        [$table, $links, $parser_links] = Ad::getTableBySites($parser_data, $local_data);

        $table = collect(compact('table', 'links'));

        $forums = $post->forums;

        $posts = Post::getRefactoredPosts($post->user->posts);
        $places = DB::table('places')->get();
        $categories = DB::table('categories')->get('title')->pluck('title');

        return view('pages.profile',
            compact('profile', 'cities', 'settings', 'table', 'parser_links', 'forums', 'posts', 'places', 'categories'));
    }

    public function profileOnlyParser($telephone) {
        [$sites, $notEmptySitesCount, $auto_renovados] = DailyStat::getSitesByTelephone($telephone);
        [$site, $cities] = User::getCalculationOfCities($sites);

        $cities = collect([
            'site' => $site,
            'cities' => collect($cities),
        ]);

        $parser_data = collect($sites);
        $local_data = Ad::wherePostId(-1)->get()->groupBy('site');
        [$table, $links, $parser_links] = Ad::getTableBySites($parser_data, $local_data);

        $table = collect(compact('table', 'links'));

        $profile = collect([
            'name' => User::getName($sites),
            'email' => 'undefined',
            'tel' => $telephone,
            'posts_count' => 0,
            'tariffs_count' => 0,
            'tariffs_sum' => 0,
            'portals_count' => $notEmptySitesCount,
            'auto_renovados' => $auto_renovados,
            'auto_renovados_sum' => $auto_renovados * 0.2,
            'avatars' => DailyStat::getAvatarsFromParser($telephone)->take(30),
        ]);

        return view('pages.profileOnlyParser', compact('profile','cities', 'table', 'parser_links'));
    }

    public function update($telephone) {
        $entity = request()->get('entity');
        $blocked = request()->get('blocked');

        /**@var User $user */
        $user = Post::wherePhone($telephone)->with('user')->first()->user;

        $response = $user->update([
            'entity' => $entity,
            'blocked' => $blocked,
        ]);

        return $this->responseJson('Success', 201, $response);

    }

    public function change($telephone) {
        $tariff = request()->get('tariff');
        $days = request()->get('days');

        $post = Post::wherePhone($telephone)->with('user', 'tariff')->first();

        $post->tariff->update([
            'status' => 'stop'
        ]);

        $price = 0;
        switch ($tariff) {
            case 'silver':
                $price = 24.95;
                break;
            case 'gold':
                $price = 99.95;
                break;
            case 'diamond':
                $price = 299.95;
                break;
        }

        $start = Carbon::now();
        $end = Carbon::now()->addDays($days);

        (new Tariff([
            'start' => $start,
            'end' => $end,
            'active' => true,
            'status' => 'complete',
            'currency' => 'EUR',
            'price' => $price,
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'name' => $tariff,
        ]))->save();

        $response = $post->update([
            'publish' => true,
            'end_pay' => $end,
        ]);

        return $this->responseJson($response, 201, $end);
    }

    public function continu($telephone) {
        $days = request()->get('days');
        $post = Post::wherePhone($telephone)->with('user')->first();

        $end = Carbon::parse($post->tariff->end)->addDays($days);

        $post->tariff->update(compact('end'));

        $response = $post->update([
            'end_pay' => $end,
        ]);

        return $this->responseJson($response, 201, $end);
    }

    public function delete($telephone) {
        $post = Post::wherePhone($telephone)->with('user')->first();

        DB::table('posts')->whereUserId($post->user->id)->delete();
        $response = DB::table('users')->whereId($post->user->id)->delete();

        return $this->responseJson('Success', 202, $response);
    }

    public function save($telephone) {
        $response = Post::wherePhone($telephone)->update(request()->all()['form']);

        return $this->responseJson('Success', 200, $response);
    }
}
