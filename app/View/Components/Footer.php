<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Page;
use App\Models\Region;
use App\Models\StaticText;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;
use TCG\Voyager\Facades\Voyager;

class Footer extends Component
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

        $footerMenuItems = Helper::menuItems('footer');

        $siteLogo = setting('site.logo');
        $siteLightLogo = setting('site.logo_light');
        $logo = $siteLogo ? Voyager::image($siteLogo) : '/img/logo.png';
        $logoLight = $siteLightLogo ? Voyager::image($siteLightLogo) : '/img/logo.png';

        $address = Helper::staticText('contact_address', 300)->getTranslatedAttribute('description');
        $workHours = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $footerDescription = Helper::staticText('footer_description', 300)->getTranslatedAttribute('description');

        $categories = Helper::categories();

        return view('components.footer', compact('footerMenuItems', 'logo', 'logoLight', 'address', 'workHours', 'footerDescription', 'categories'));
    }
}
