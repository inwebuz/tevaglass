<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class DeliverySettingsController extends Controller
{
    public function index(Request $request)
    {
        $this->checkPermissions();
        $free = ShippingMethod::where('name', 'Free')->firstOrFail();
        $standard = ShippingMethod::where('name', 'Standard')->firstOrFail();
        return Voyager::view('voyager::delivery_settings.index', compact('free', 'standard'));
    }

    public function update(Request $request)
    {
        $this->checkPermissions();

        $data = $request->validate([
            'price' => 'required|numeric',
            'order_min_price' => 'required|numeric',
        ]);

        ShippingMethod::where('name', 'Free')->update([
            'order_min_price' => $data['order_min_price'],
        ]);
        ShippingMethod::where('name', 'Standard')->update([
            'order_max_price' => $data['order_min_price'] - 0.01,
            'price' => $data['price'],
        ]);

        return redirect()->route('voyager.delivery_settings.index')->with([
            'message'    => 'Настройки сохранены',
            'alert-type' => 'success',
        ]);
    }

    private function checkPermissions()
    {
        $this->authorize('browse_admin');
        return true;
    }
}
