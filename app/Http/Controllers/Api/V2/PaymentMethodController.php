<?php

namespace App\Http\Controllers\Api\V2;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'app');
        $paymentMethods = [];
        if ($type == 'app') {
            $paymentMethods = Helper::paymentMethodsApp();
        } elseif ($type == 'desktop') {
            $paymentMethods = Helper::paymentMethodsDesktop();
        }
        return PaymentMethodResource::collection($paymentMethods);
    }
}
