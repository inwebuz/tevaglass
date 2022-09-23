<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaticText extends Model
{
    use Resizable;
    use Translatable;
    use HasFactory;

    protected $translatable = ['name', 'description', 'url'];

    /**
     * Get original image
     */
    public function getImgAttribute()
    {
        return Voyager::image($this->image);
    }
}
