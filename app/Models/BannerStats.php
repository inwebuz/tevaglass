<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Banner;

class BannerStats extends Model
{
    protected $guarded = [];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
