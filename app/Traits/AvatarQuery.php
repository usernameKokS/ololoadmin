<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait AvatarQuery
{
    public static function getAbsolutePathOfAvatars(Collection $avatars) {
        return $avatars->map(function ($avatar) {
            return env('MAIN_SITE_URL') . '/storage' .$avatar;
        });
    }
}
