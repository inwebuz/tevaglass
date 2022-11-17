<?php

namespace App\View\Components;

use App\Models\Category;
use App\Helpers\Helper;
use App\Models\Page;
use App\Models\Region;
use App\Models\StaticText;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;
use TCG\Voyager\Facades\Voyager;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();

        // $banner = Helper::banner('top_1');
        // $menuItems = Helper::menuItems();
        $headerMenuItems = Helper::menuItems('header');
        $siteLogo = setting('site.logo');
        $logo = $siteLogo ? Voyager::image($siteLogo) : '/img/logo.png';
        $siteLogoLight = setting('site.logo_light');
        $logoLight = $siteLogoLight ? Voyager::image($siteLogoLight) : '/img/logo-light.png';

        // $switcher = Helper::languageSwitcher();
        // $activeLanguageRegional = Helper::getActiveLanguageRegional();

        // $address = Helper::staticText('contact_address', 300)->getTranslatedAttribute('description');
        // $workHours = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');

        $categories = Category::active()->parents()->withTranslation($locale)->orderBy('order')->latest()->get();

        $q = request('q', '');

        $badEye = json_decode(request()->cookie('bad_eye'), true);
        if (!$badEye) {
            $badEye = [
                'font_size' => 'normal',
                'contrast' => 'normal',
                'images' => 'normal',
            ];
        }

        return view('components.header', compact('headerMenuItems', 'logo', 'logoLight', 'q', 'badEye', 'categories'));
    }
}
