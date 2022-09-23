<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::where('name', '!=', 'admin')->get();
        return MenuResource::collection($menus);
    }

    public function show(Request $request, Menu $menu)
    {
        if ($menu->name == 'admin') {
            abort(404);
        }
        $locale = app()->getLocale();
        $menu->load(['menuItems' => function($query) use ($locale) {
            $query->withTranslation($locale);
        }]);
        return new MenuResource($menu);
    }
}
