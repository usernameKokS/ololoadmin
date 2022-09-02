<?php

namespace App\Traits;

use App\Post;
use App\Tariff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

trait PostQueries
{
    public static function getAllPosts() {
        return Post::whereArchive(0)->whereStatus('create')->latest();
    }

    public static function getActivePostsCount(Collection $posts) {
        return Post::whereHas('tariffs', function($q){
            $q->where('end', '>', Carbon::now());
        })->count();
    }

    public static function getPostsCategoryWithItsEntity() {
        $posts = Post::with([
            'user' => function (BelongsTo $q) {
                $q->select(['id', 'entity']);
            },
        ])->get(['id', 'user_id', 'category']);

        foreach ($posts as $post) {
            $post->entity = $post->user->entity;
        }

        return $posts;
    }

    public static function getRefactoredPosts(Collection $posts) {
        foreach ($posts as $post) {
            $post->main_avatar = isset($post->avatars[0]) ? env('MAIN_SITE_URL').'/storage'. $post->avatars[0]->url : null;
        }

        return $posts;
    }
}
