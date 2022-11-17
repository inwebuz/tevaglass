<?php

namespace App\Models;

use App\Events\ModelDeleted;
use App\Events\ModelSaved;
use App\Events\ProductCreated;
use App\Events\ProductSaved;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Translation;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;

class Product extends Model
{
    use Resizable;
    use Translatable;
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    const SOURCE_ADMIN = 0;
    const SOURCE_IMPORT = 1;
    const SOURCE_API = 2;

    const FEATURED_INACTIVE = 0;
    const FEATURED_ACTIVE = 1;

    const NEW_INACTIVE = 0;
    const NEW_ACTIVE = 1;

    const BESTSELLER_INACTIVE = 0;
    const BESTSELLER_ACTIVE = 1;

    const PROMOTION_INACTIVE = 0;
    const PROMOTION_ACTIVE = 1;

    const POPULAR_INACTIVE = 0;
    const POPULAR_ACTIVE = 1;

    public static $imgSizes = [
        // 'micro' => [62, 62],
        'small' => [360, 360],
        'medium' => [585, 585],
        // 'large' => [900, 900],
    ];

    protected $appends = [
        'url',
        'current_price',
        'current_sale_price',
        'current_not_sale_price',
        'img',
        'category_ids',
    ];

    protected $translatable = ['name', 'slug', 'description', 'body', 'specifications', 'seo_title', 'meta_description', 'meta_keywords', 'h1_name'];

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ProductCreated::class,
        'saved' => ProductSaved::class,
        'deleted' => ModelDeleted::class,
    ];

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            if (!$model->user_id && auth()->user()) {
                $model->user_id = auth()->user()->id;
            }
        });
        self::created(function ($model) {
            // Helper::addInitialReview($model);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function importPartner()
    {
        return $this->belongsTo(ImportPartner::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)->withPivot('quantity');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function searches()
    {
        return $this->morphMany(Search::class, 'searchable');
    }

    public function banners()
    {
        return $this->morphMany(Banner::class, 'targetable');
    }

    public function activeReviews()
    {
        return $this->reviews()->active();
    }

    public function stickers()
    {
        return $this->belongsToMany(Sticker::class);
    }

    /**
     * Get the attributes.
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('order');
    }

	public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    /**
     * Get the attribute values.
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class)->withPivot('image');
    }

    /**
     * Get the attribute values ids.
     */
    public function attributeValuesIds()
    {
        return $this->attributeValues()->pluck('attribute_value_id');
    }

    /**
     * Get the attributes ordered.
     */
    public function attributesOrdered()
    {
        return $this->attributes()->orderBy('pivot_order');
    }

    public function attributesWithValues()
    {
        return $this->attributes()->orderBy('pivot_order')->with('attributeValues', function($q) {
            $q->whereIn('id', $this->attributeValuesIds());
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCategoryIDsAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }

    /**
     * Get url
     */
    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    /**
     * Get url
     */
    public function getUrl($lang = '')
    {
        if (!$lang) {
            $lang = app()->getLocale();
        }
        $slug = $this->getTranslatedAttribute('slug', $lang) ?: $this->slug;
        $url = 'product/' . $this->id . '-' . $slug;
        return LaravelLocalization::localizeURL($url, $lang);
    }

    /**
     * Get background image
     */
    public function getBgAttribute()
    {
        return Voyager::image($this->background);
    }

    /**
     * Get main image
     */
    public function getImgAttribute()
    {
        return $this->image ? Voyager::image($this->image) : asset('images/no-product-image.jpg');
    }

    /**
     * Get micro image
     */
    public function getMicroImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'micro')) : asset('images/no-product-image.jpg');
    }

    /**
     * Get small image
     */
    public function getSmallImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'small')) : asset('images/no-product-image.jpg');
    }

    /**
     * Get medium image
     */
    public function getMediumImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'medium')) : asset('images/no-product-image.jpg');
    }

    /**
     * Get large image
     */
    public function getLargeImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'large')) : asset('images/no-product-image.jpg');
    }

    /**
     * Get second small image
     */
    public function getSecondSmallImgAttribute()
    {
        return $this->gallery_small_img ? $this->gallery_small_img : $this->small_img;
    }

    /**
     * Get second medium image
     */
    public function getSecondMediumImgAttribute()
    {
        return $this->gallery_medium_img ? $this->gallery_medium_img : $this->medium_img;
    }

    /**
     * Get gallery micro images
     */
    public function getMicroImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'micro');
    }

    /**
     * Get gallery small images
     */
    public function getSmallImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'small');
    }

    /**
     * Get gallery medium images
     */
    public function getMediumImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'medium');
    }

    /**
     * Get gallery large images
     */
    public function getLargeImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'large');
    }

    /**
     * Get gallery original images
     */
    public function getImgsAttribute()
    {
        return $this->getImgsGroup($this->images);
    }

    /**
     * Get gallery small first image
     */
    public function getGallerySmallImgAttribute()
    {
        $images = $this->getImgsGroup($this->images, 'small');
        return $images[0] ?? '';
    }

    /**
     * Get gallery medium first image
     */
    public function getGalleryMediumImgAttribute()
    {
        $images = $this->getImgsGroup($this->images, 'medium');
        return $images[0] ?? '';
    }

    /**
     * get raw images
     */
    private function getImgsGroup($images, $type = '')
    {
        $group = [];
        $getImages = json_decode($images);
        if (is_array($getImages)) {
            foreach ($getImages as $value) {
                $group[] = ($type == '') ? Voyager::image($value) : Voyager::image($this->getThumbnail($value, $type));
            }
        }
        return $group;
    }

    /**
     * Get first category
     */
    public function getCategoryFirstAttribute()
    {
        $locale = app()->getLocale();
        $category = null;
        if (!$this->categories->isEmpty()) {
            $category = $this->categories->withTranslation($locale)->first();
        }
        return $category;
    }

    /**
     * Get active reviews average rating
     */
    public function getRatingAvgAttribute()
    {
        // return $this->rating > 0 && $this->rating <= 5 ? (int)$this->rating : 5;
        return floatval($this->activeReviews->avg('rating'));
    }

    /**
     * Get active reviews count
     */
    public function getRatingCountAttribute()
    {
        return $this->activeReviews->count();
    }

    public function getCurrentPriceAttribute()
    {
        $currentPrice = $this->isDiscounted() ? $this->sale_price : $this->price;
        // $currentPrice =  $this->isDiscounted() ? ($this->price * (1 - $this->discount / 100)) : $this->price;
        return round(Helper::exchangeRate() * $currentPrice, 2);
    }

    public function getCurrentSalePriceAttribute()
    {
        return round(Helper::exchangeRate() * $this->sale_price, 2);
    }

    public function getCurrentNotSalePriceAttribute()
    {
        return round(Helper::exchangeRate() * $this->price, 2);
    }

    public function getOldPriceAttribute()
    {
        return $this->current_not_sale_price;
    }

    public function getCurrentMinPricePerMonthAttribute()
    {
        return round(Helper::exchangeRate() * $this->min_price_per_month, 2);
    }

    public function getShortNameAttribute()
    {
        return Str::limit($this->name, 40, ' ...');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::words($this->description, 10, ' ...');
    }

    public function getDiscountPercentAttribute()
    {
        $discount = 0;
        if ($this->isDiscounted()) {
            $discount = round((1 - $this->sale_price / $this->price) * 100);
        }
        return $discount;
    }

    /**
     * Get status title
     */
    public function getStatusTitleAttribute()
    {
        return static::statuses()[$this->status];
    }

    public static function statuses() {
        return [
            static::STATUS_INACTIVE => __('main.status_inactive'),
            static::STATUS_PENDING => __('main.status_pending'),
            static::STATUS_ACTIVE => __('main.status_active'),
        ];
    }

    public function installmentPrices()
    {
        $exchangeRate = Helper::exchangeRate();
        $installmentPrice3 = $exchangeRate * $this->installment_price_3;
        $installmentPrice6 = $exchangeRate * $this->installment_price_6;
        $installmentPrice12 = $exchangeRate * $this->installment_price_12;
        return [
            [
                'duration' => 3,
                'current_price' => $installmentPrice3,
                'current_price_formatted' => Helper::formatPrice($installmentPrice3),
            ],
            [
                'duration' => 6,
                'current_price' => $installmentPrice6,
                'current_price_formatted' => Helper::formatPrice($installmentPrice6),
            ],
            [
                'duration' => 12,
                'current_price' => $installmentPrice12,
                'current_price_formatted' => Helper::formatPrice($installmentPrice12),
            ],
        ];
        // return [];
    }

    /**
     * check if product is simple
     */
    public function isSimple()
    {
        return true;
        // return $this->type == static::TYPE_SIMPLE;
    }

    public function isActive()
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    public function isNew()
    {
        return $this->is_new == static::NEW_ACTIVE;
    }

    public function isBestseller()
    {
        return $this->is_bestseller == static::BESTSELLER_ACTIVE;
    }

    public function isPromotion()
    {
        return $this->is_promotion == static::PROMOTION_ACTIVE;
    }

    /**
     * check if product is composite
     */
    public function isComposite()
    {
        return false;
        // return $this->type == static::TYPE_COMPOSITE;
    }

    /**
     * check if product has valid discount
     */
    public function isDiscounted()
    {
        return ($this->sale_price > 0 && $this->sale_price < $this->price);
        //return ($this->is_special && $this->discount > 0 && $this->discount <= 100);
    }

    /**
     * check if product is in stock
     */
    public function isAvailable()
    {
        return ($this->status == static::STATUS_ACTIVE && $this->getStock() > 0);
    }

    /**
     * check if product is in stock
     */
    public function getStock()
    {
        return $this->in_stock;
        // $stock = 0;
        // $regionID = Cookie::get('region_id') ?: 14;
        // $warehouses = $this->warehouses->where('region_id', $regionID);
        // foreach ($warehouses as $warehouse) {
        //     $stock += $warehouse->pivot->quantity;
        // }
        // return $stock;
    }

    /**
     * check if product is not in stock
     */
    public function isNotAvailable()
    {
        return ($this->getStock() == 0);
    }

    /**
     * check if product is under order
     */
    public function isUnderOrder()
    {
        return false;
        // return ($this->in_stock == static::STOCK_UNDER_ORDER);
    }

    /**
     * scope active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * scope similar
     */
    public function scopeSimilar($query)
    {
        $category = $this->categories->first();
        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }
        $query->where('products.id', '!=', $this->id);
        return $query;
    }

    /**
     * scope popular
     */
    public function scopePopular($query, Category $category)
    {
        return $query->where([['category_id', $category->id], ['is_popular', Product::POPULAR_ACTIVE]]);
    }

    /**
     * scope featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', self::FEATURED_ACTIVE);
    }

    /**
     * scope bestseller
     */
    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', self::BESTSELLER_ACTIVE);
    }

    /**
     * scope promotion
     */
    public function scopePromotion($query)
    {
        return $query->where('is_promotion', self::PROMOTION_ACTIVE);
    }

    /**
     * scope new
     */
    public function scopeNew($query)
    {
        return $query->where('is_new', self::NEW_ACTIVE);
    }

    /**
     * scope new
     */
    public function scopeDiscounted($query)
    {
        return $query->where('sale_price', '>', 0)->whereColumn('sale_price', '<', 'price');
    }
}
