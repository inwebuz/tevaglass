<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('site.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.title'),
                //'value'        => __('seeders.settings.site.title'),
                'value'        => 'TevaGlass',
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Site',
            ])->save();
        }

        // $setting = $this->findSetting('site.description');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.site.description'),
        //         'value'        => __('seeders.settings.site.description'),
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 2,
        //         'group'        => 'Site',
        //     ])->save();
        // }

        $setting = $this->findSetting('site.logo');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.logo'),
                'value'        => 'settings/logo.png',
                'details'      => '',
                'type'         => 'image',
                'order'        => 3,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.logo_light');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.logo_light'),
                'value'        => 'settings/logo-light.png',
                'details'      => '',
                'type'         => 'image',
                'order'        => 4,
                'group'        => 'Site',
            ])->save();
        }

        // $setting = $this->findSetting('site.exchange_rate');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => 'Курс У.Е.',
        //         'value'        => '1',
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 5,
        //         'group'        => 'Site',
        //     ])->save();
        // }

        // $setting = $this->findSetting('site.favicon');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.site.favicon_ico'),
        //         'value'        => '',
        //         'details'      => '',
        //         'type'         => 'file',
        //         'order'        => 4,
        //         'group'        => 'Site',
        //     ])->save();
        // }

        $setting = $this->findSetting('site.google_analytics_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.google_analytics_code'),
                'value'        => '',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 10,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.yandex_metrika_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.yandex_metrika_code'),
                'value'        => '',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 11,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.facebook_pixel_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.site.facebook_pixel_code'),
                'value'        => '',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 12,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.jivochat_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Код Jivochat',
                'value'        => '',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 13,
                'group'        => 'Site',
            ])->save();
        }

        // $setting = $this->findSetting('site.share_buttons_code');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => 'Код кнопки Поделиться',
        //         'value'        => '<img src="/images/share.jpg" alt="Share" class="img-fluid">',
        //         'details'      => '',
        //         'type'         => 'text_area',
        //         'order'        => 20,
        //         'group'        => 'Site',
        //     ])->save();
        // }

        $setting = $this->findSetting('site.inweb_widget_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Код виджета Inweb',
                'value'        => '',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 30,
                'group'        => 'Site',
            ])->save();
        }



        // $setting = $this->findSetting('site.counters');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => 'Счетчики',
        //         'value'        => '
        //                             <a href="#" class="d-inline-block mb-2 mb-lg-0">
        //                                 <img src="/images/counter-1.png" alt="">
        //                             </a>
        //                             <a href="#" class="d-inline-block mb-2 mb-lg-0">
        //                                 <img src="/images/counter-2.png" alt="">
        //                             </a>
        //                             <a href="#" class="d-inline-block mb-2 mb-lg-0">
        //                                 <img src="/images/counter-3.png" alt="">
        //                             </a>
        //                             ',
        //         'details'      => '',
        //         'type'         => 'text_area',
        //         'order'        => 15,
        //         'group'        => 'Site',
        //     ])->save();
        // }

        // $setting = $this->findSetting('admin.bg_image');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.admin.background_image'),
        //         'value'        => '',
        //         'details'      => '',
        //         'type'         => 'image',
        //         'order'        => 5,
        //         'group'        => 'Admin',
        //     ])->save();
        // }

        $setting = $this->findSetting('admin.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.admin.title'),
                'value' => __('seeders.settings.admin.title_value'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.admin.description'),
                'value'        => __('seeders.settings.admin.description_value'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 2,
                'group'        => 'Admin',
            ])->save();
        }

        // $setting = $this->findSetting('admin.loader');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.admin.loader'),
        //         'value'        => '',
        //         'details'      => '',
        //         'type'         => 'image',
        //         'order'        => 3,
        //         'group'        => 'Admin',
        //     ])->save();
        // }

        // $setting = $this->findSetting('admin.icon_image');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.admin.icon_image'),
        //         'value'        => '',
        //         'details'      => '',
        //         'type'         => 'image',
        //         'order'        => 4,
        //         'group'        => 'Admin',
        //     ])->save();
        // }

        // $setting = $this->findSetting('admin.google_analytics_client_id');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.admin.google_analytics_client_id'),
        //         'value'        => '',
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 1,
        //         'group'        => 'Admin',
        //     ])->save();
        // }

        $setting = $this->findSetting('contact.email');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.email'),
                'value'        => 'tevaglass@gmail.com',
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.phone');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.phone'),
                'value'        => '(908) 650-6333',
                'details'      => '',
                'type'         => 'text',
                'order'        => 2,
                'group'        => 'Contact',
            ])->save();
        }

        // $setting = $this->findSetting('contact.fax');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.contact.fax'),
        //         'value'        => __('seeders.settings.contact.fax_value'),
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 3,
        //         'group'        => 'Contact',
        //     ])->save();
        // }

        // $setting = $this->findSetting('contact.address');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.contact.address'),
        //         'value'        => __('seeders.settings.contact.address_value'),
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 4,
        //         'group'        => 'Contact',
        //     ])->save();
        // }

        // $setting = $this->findSetting('contact.landmark');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.contact.landmark'),
        //         'value'        => __('seeders.settings.contact.landmark_value'),
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 5,
        //         'group'        => 'Contact',
        //     ])->save();
        // }

        $setting = $this->findSetting('contact.map');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.map'),
                'value'        => '<iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2998.5186682413187!2d69.20349701548685!3d41.275814979274486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8ba6500ade71%3A0x54d4614c8e73f4ec!2zSW53ZWIgLSDQodC-0LfQtNCw0L3QuNC1INGB0LDQudGC0L7QsiDQsiDQotCw0YjQutC10L3RgtC1!5e0!3m2!1sen!2s!4v1659090374580!5m2!1sen!2s"
                width="100%"
                height="100%"
                style="border: 0"
                allowfullscreen="true"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>',
                'details'      => '',
                'type'         => 'text_area',
                'order'        => 6,
                'group'        => 'Contact',
            ])->save();
        }

        // $setting = $this->findSetting('contact.work_hours');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => __('seeders.settings.contact.work_hours'),
        //         'value'        => '9:00–18:00',
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 7,
        //         'group'        => 'Contact',
        //     ])->save();
        // }

        $setting = $this->findSetting('contact.telegram');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.telegram'),
                'value'        => __('seeders.settings.contact.telegram_value'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 20,
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.facebook');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.facebook'),
                'value'        => __('seeders.settings.contact.facebook_value'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 21,
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.instagram');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('seeders.settings.contact.instagram'),
                'value'        => __('seeders.settings.contact.instagram_value'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 22,
                'group'        => 'Contact',
            ])->save();
        }

        // $setting = $this->findSetting('currency.usd');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => 'USD',
        //         'value'        => 0,
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 1,
        //         'group'        => 'Currency',
        //     ])->save();
        // }

        // $setting = $this->findSetting('currency.eur');
        // if (!$setting->exists) {
        //     $setting->fill([
        //         'display_name' => 'EUR',
        //         'value'        => 0,
        //         'details'      => '',
        //         'type'         => 'text',
        //         'order'        => 2,
        //         'group'        => 'Currency',
        //     ])->save();
        // }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
