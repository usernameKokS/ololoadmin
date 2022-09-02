<?php

namespace App;

use App\Traits\AvatarQuery;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use AvatarQuery;
}
