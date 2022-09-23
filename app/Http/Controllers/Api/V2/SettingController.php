<?php

namespace App\Http\Controllers\Api\V2;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $appUrl = config('app.url');
        $data = [
            'title' => Helper::setting('site.title', 300),
            'logo' => $appUrl . Voyager::image(Helper::setting('site.logo', 300)),
            'logo_light' => $appUrl . Voyager::image(Helper::setting('site.logo_light', 300)),
            'google_analytics_code' => Helper::setting('site.google_analytics_code', 300),
            'yandex_metrika_code' => Helper::setting('site.yandex_metrika_code', 300),
            'facebook_pixel_code' => Helper::setting('site.facebook_pixel_code', 300),
            'email' => Helper::setting('contact.email', 300),
            'phone' => Helper::setting('contact.phone', 300),
            'telegram' => Helper::setting('contact.telegram', 300),
            'facebook' => Helper::setting('contact.facebook', 300),
            'instagram' => Helper::setting('contact.instagram', 300),
            'youtube' => Helper::setting('contact.youtube', 300),
            'tiktok' => Helper::setting('contact.tiktok', 300),
        ];
        return response()->json($data);
    }
}
