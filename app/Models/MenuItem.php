<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use Translatable;
    use HasFactory;

    protected $translatable = ['title', 'url'];

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
