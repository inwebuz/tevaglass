<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributesTemplate extends Model
{
    use HasFactory;
    use Translatable;

    protected $guarded = [];

    protected $translatable = ['name'];

    protected $casts = [
        'body' => AsArrayObject::class,
    ];
}
