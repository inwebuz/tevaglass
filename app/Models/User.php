<?php

namespace App\Models;

use App\Events\UserSaved;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory, Resizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'address', 'first_name', 'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $imgSizes = [
        'small' => [100, 100],
        'medium' => [400, 400],
        // 'large' => [900, 900],
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];

    /**
     * Get url
     */
    public function getURLAttribute()
    {
        return LaravelLocalization::localizeURL('user/' . $this->id);
    }

    /**
     * Get main image
     */
    public function getAvatarImgAttribute()
    {
        return ($this->avatar && $this->avatar != 'users/default.png') ? Voyager::image($this->avatar) : asset('images/avatar.png');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function userApplications()
    {
        return $this->hasMany(UserApplication::class);
    }

    public function otps()
    {
        return $this->morphMany(Otp::class, 'otpable');
    }

    public function isPhoneVerified()
    {
        return $this->phone_number_verified_at;
    }

    public function isSeller()
    {
        return $this->role->name == 'seller';
    }

    public function isAdmin()
    {
        return ($this->role->name == 'admin' || $this->role->name == 'administrator');
    }

    public function getImgAttribute()
    {
        return $this->avatar ? Voyager::image($this->avatar) : asset('images/avatar.png');
    }

    public function getSmallImgAttribute()
    {
        return $this->avatar ? Voyager::image($this->getThumbnail($this->avatar, 'small')) : asset('images/avatar.png');
    }

    public function getMediumImgAttribute()
    {
        return $this->avatar ? Voyager::image($this->getThumbnail($this->avatar, 'medium')) : asset('images/avatar.png');
    }
}
