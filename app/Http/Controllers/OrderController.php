<?php

namespace App\Http\Controllers;

use App\AlifshopApplication;
use App\AlifshopApplicationItem;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\InstallmentOrder;
use App\Mail\NewOrderAdminMail;
use App\Mail\NewOrderClientMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PartnerInstallment;
use App\Models\Product;
use App\Services\AlifshopAzoService;
use App\Services\IntendService;
use App\Services\TelegramService;
use App\Models\ShippingMethod;
use App\Models\ZoodpayTransaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function show(Request $request, Order $order, $check)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.order'), $order->url), LinkItem::STATUS_INACTIVE);

        if ($check != md5($order->created_at)) {
            abort(403);
        }

        $zoodpayTransaction = null;
        if ($order->payment_method_id == Order::PAYMENT_METHOD_ZOODPAY_INSTALLMENTS) {
            $zoodpayTransaction = ZoodpayTransaction::where('order_id', $order->id)->latest()->first();
        }

        return view('order.show', compact('order', 'breadcrumbs', 'zoodpayTransaction'));
    }

    /**
     * Create new order
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function add(Request $request)
    {
        // cart empty error
        if (app('cart')->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $data = $request->validate([
            'name' => 'required|max:191',
            'phone_number' => 'required|regex:/^\+998\d{2}\s\d{3}-\d{2}-\d{2}$/',
            'email' => 'email|max:191',
            'address_line_1' => 'max:50000',
            'shipping_name' => 'max:191',
            'shipping_phone_number' => '',
            'shipping_email' => 'nullable|email|max:191',
            'shipping_address' => 'max:50000',
            'message' => 'max:50000',
            // 'type' => 'required|integer|in:' . implode(',', array_keys(Order::types())),
            'communication_method' => 'required|integer|between:0,2',
            'payment_method_id' => 'required|integer|in:' . implode(',', Helper::paymentMethodsIds()),
            'public_offer' => '',
            'latitude' => '',
            'longitude' => '',
            'location_accuracy' => '',
        ], [
            'public_offer.required' => __('main.you_must_accept_public_offer'),
        ]);

        $cart = app('cart');
        $total = $cart->getTotal();

        $shippingMethods = ShippingMethod::active()->orderBy('order')->get();
        $shippingMethod = $shippingMethods->where('order_min_price', '<=', $total)->where('order_max_price', '>=', $total)->first();
        if (!$shippingMethod) {
            $shippingMethod = $shippingMethods->first();
        }

        $data['shipping_method_id'] = $shippingMethod->id ?? null;
        $data['shipping_price'] = $shippingMethod->price ?? 0;

        $data['status'] = Order::STATUS_PENDING;

        if (empty($data['address_line_1'])) {
            $data['address_line_1'] = '';
        }
        if (empty($data['message'])) {
            $data['message'] = '';
        }

        $data['user_id'] = auth()->check() ? auth()->user()->id : null;

        $data['subtotal'] = $cart->getSubtotal();
        $data['total'] = $cart->getTotal() + $data['shipping_price'];

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->server('HTTP_USER_AGENT');

        unset($data['public_offer']);

        // check and set installment
        $data['type'] = Order::TYPE_BUY_IMMEDIATELY;
        // $orderTypes = Order::types();
        // $data['type'] = (int)$data['type'];
        // if (!array_key_exists($data['type'], $orderTypes)) {
        //     $data['type'] = Order::TYPE_BUY_IMMEDIATELY;
        // }

        $order = Order::create($data);

        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.cart'), route('cart.index')));
        foreach ($cart->getContent() as $cartItem) {
            $product = $cartItem->associatedModel;
            $orderItemData = [
                'order_id' => $order->id,
                'name' => $cartItem->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'subtotal' => $cartItem->getPriceSum(),
                'total' => $cartItem->getPriceSumWithConditions(),
                'product_id' => $product->id,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'import_partner_id' => $product->import_partner_id,
            ];

            OrderItem::create($orderItemData);
        }

        // clear cart
        app('cart')->clear();

        // load relations
        $order->load('orderItems');

        // send notification to telegram admin
        $telegramService = new TelegramService();
        $telegramMessage = view('telegram.admin.new_order', ['url' => route('voyager.orders.show', $order->id), 'order' => $order])->render();
        try {
            // send telegram message
            $chat_id = config('services.telegram.chat_id');
            $telegramService->sendMessage($chat_id, $telegramMessage, 'HTML');
            if ($order->latitude && $order->longitude) {
                $locationParams = [];
                if ($order->location_accuracy) {
                    $locationParams['horizontal_accuracy'] = $order->location_accuracy;
                }
                $telegramService->sendLocation($chat_id, $order->latitude, $order->longitude, $locationParams);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            // send email to admin
            Mail::to(setting('contact.email'))->send(new NewOrderAdminMail($order));
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            // send email to client
            if ($order->email) {
                Mail::to($order->email)->send(new NewOrderClientMail($order));
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->to($order->url)->withSuccess(__('main.order_accepted') . '. ' . __('main.status') . ': ' . $order->status_title);
    }

    public function print(Request $request, Order $order, $check)
    {
        $locale = app()->getLocale();

        if ($check != md5($order->created_at)) {
            abort(403);
        }

        return view('order.print', compact('order'));
    }
}
