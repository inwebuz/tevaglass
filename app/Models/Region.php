<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Region extends Model
{
    use Translatable;

    protected $guarded = [];

    protected $translatable = ['name', 'short_name'];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
