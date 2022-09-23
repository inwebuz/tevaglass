<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Gender extends Model
{
    use Translatable;

    protected $translatable = ['name'];

    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
