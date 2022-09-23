<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;

class ShippingMethod extends Model
{
    use Resizable;
    use Translatable;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

    public static $imgSizes = [
        'micro' => [50, 50],
    ];

    protected $appends = [
        'img',
    ];

    protected $translatable = ['name', 'description'];

    protected $guarded = [];

    /**
     * scope active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
