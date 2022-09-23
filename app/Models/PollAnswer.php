<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;

class PollAnswer extends Model
{
    use Translatable;
    use Resizable;

    protected $translatable = ['answer'];

    protected $guarded = [];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
