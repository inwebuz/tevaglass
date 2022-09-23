<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Models\Product;
use App\Models\StaticText;
use Illuminate\Http\Request;

class ContactsController extends ApiController
{
    public function index(Request $request)
    {
        $data = [
            'site' => config('app.url'),
            'site_title' => setting('site.title'),
            'phone' => setting('contact.phone'),
            'email' => setting('contact.email'),
            'address' => Helper::staticText('contact_address', 300)->getTranslatedAttribute('description'),
        ];
        return $data;
    }
}
