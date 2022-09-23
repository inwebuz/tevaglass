<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtmosTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payable()
    {
        return $this->morphTo();
    }
}
