<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Order;
use App\Models\Page;
use App\Models\PartnerInstallment;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.cart'), route('cart.index'), LinkItem::STATUS_INACTIVE));
        $cart = app('cart');
        $cartItems = $cart->getContent()->sortBy('id');
        $standardPriceTotal = 0;
        $checkoutAvailable = true;
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->associatedModel;
            $standardPriceTotal += $product->current_not_sale_price * $cartItem->quantity;
            $stock = $product->getStock();
            $cartItem->availableQuantity = $stock;
            if ($stock < $cartItem->quantity) {
                $checkoutAvailable = false;
            }
        }
        $discount = $standardPriceTotal - $cart->getTotal();

        $addresses = collect();
        $address = null;
        if (auth()->check()) {
            $user = auth()->user();
            $addresses = $user->addresses;
            $address = $user->addresses()->where('status', Address::STATUS_ACTIVE)->latest()->first();
            if (!$address) {
                $address = $user->addresses()->latest()->first();
                if ($address) {
                    $address->update(['status' => Address::STATUS_ACTIVE]);
                }
            }
        }

        return view('cart', compact('breadcrumbs', 'cart', 'cartItems', 'checkoutAvailable', 'standardPriceTotal', 'discount', 'address', 'addresses'));
    }

    public function checkout(Request $request)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.cart'), route('cart.index')));
        $breadcrumbs->addItem(new LinkItem(__('main.checkout'), route('cart.checkout'), LinkItem::STATUS_INACTIVE));

        $isGift = $request->input('gift', '');

        $cart = app('cart');
        $cartItems = $cart->getContent()->sortBy('id');
        $publicOfferPage = Page::find(12);

        $shippingMethods = ShippingMethod::active()->orderBy('order')->get();
        $total = $cart->getTotal();
        $shippingMethod = $shippingMethods->where('order_min_price', '<=', $total)->where('order_max_price', '>=', $total)->first();
        if (!$shippingMethod) {
            $shippingMethod = $shippingMethods->first();
        }

        $checkoutAvailable = true;
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->associatedModel;
            $stock = $product->getStock();
            $cartItem->availableQuantity = $stock;
            if ($stock < $cartItem->quantity) {
                $checkoutAvailable = false;
            }
        }

        $address = null;
        if (auth()->check()) {
            $user = auth()->user();
            $address = $user->addresses()->where('status', Address::STATUS_ACTIVE)->latest()->first();
            if (!$address) {
                $address = $user->addresses()->latest()->first();
                if ($address) {
                    $address->update(['status' => Address::STATUS_ACTIVE]);
                }
            }
        }

        $orderTypes = Order::types();
        $communicationMethods = Order::communicationMethods();
        $paymentMethods = Helper::paymentMethodsDesktop();

        return view('checkout', compact('breadcrumbs', 'shippingMethods', 'shippingMethod', 'cart', 'cartItems', 'checkoutAvailable', 'publicOfferPage', 'orderTypes', 'communicationMethods', 'paymentMethods', 'address', 'isGift'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer'
        ]);

        $data['price'] = (float)$data['price'];
        $data['quantity'] = (int)$data['quantity'];

        $data['associatedModel'] = Product::findOrFail($data['id']);

        if (
            $data['associatedModel']->current_price != $data['price']
			// || trim($data['associatedModel']->name) != trim($data['name'])
        ) {
            abort(400);
        }

        // Log::info($data);

        app('cart')->add($data);

        return response([
            'cart' => $this->getCartInfo(app('cart')),
            'message' => __('main.product_added_to_cart'),
        ], 201);
    }

    public function debug(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer'
        ]);
        $data['associatedModel'] = Product::findOrFail($request->input('id'));

        $cart = app('cart')->add($data);
        $cart = $cart->getContent()->toArray();
        dd($cart);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        app('cart')->update($data['id'], [
            'quantity' => [
                'relative' => false,
                'value' => $data['quantity'],
            ],
        ]);

        $item = app('cart')->get($data['id']);

        $lineTotal = $item->getPriceSum();

        return response([
            'cart' => $this->getCartInfo(app('cart')),
            'lineTotal' => $lineTotal,
            'lineTotalFormatted' => Helper::formatPrice($lineTotal),
            'message' => __('main.cart_updated')
        ], 200);
    }

    public function delete($id)
    {
        app('cart')->remove($id);

        return response(array(
            'cart' => $this->getCartInfo(app('cart')),
            'message' => __('main.product_removed_from_cart')
        ), 200);
    }

    public function addCondition()
    {
        $v = validator(request()->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
            'target' => 'required|string',
            'value' => 'required|string',
        ]);

        if ($v->fails()) {
            return response(array(
                'success' => false,
                'data' => [],
                'message' => $v->errors()->first()
            ), 400, []);
        }

        $name = request('name');
        $type = request('type');
        $target = request('target');
        $value = request('value');

        $cartCondition = new CartCondition([
            'name' => $name,
            'type' => $type,
            'target' => $target, // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => $value,
            'attributes' => array()
        ]);

        app('cart')->condition($cartCondition);

        return response(array(
            'success' => true,
            'data' => $cartCondition,
            'message' => "condition added."
        ), 201, []);
    }

    public function clearCartConditions()
    {
        app('cart')->clearCartConditions();

        return response(array(
            'success' => true,
            'data' => [],
            'message' => "cart conditions cleared."
        ), 200, []);
    }

    private function getCartInfo($cart)
    {
        $subtotal = $cart->getSubtotal();
        $total = $cart->getTotal();

        $standardPriceTotal = 0;
        $cartItems = $cart->getContent()->sortBy('id');
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->associatedModel;
            $standardPriceTotal += $product->current_not_sale_price * $cartItem->quantity;
        }

        $discount = $standardPriceTotal - $total;

        return [
            'quantity' => $cart->getTotalQuantity(),
            'subtotal' => $subtotal,
            'subtotalFormatted' => Helper::formatPrice($subtotal),
            'total' => $total,
            'totalFormatted' => Helper::formatPrice($total),
            'standardPriceTotal' => $standardPriceTotal,
            'standardPriceTotalFormatted' => Helper::formatPrice($standardPriceTotal),
            'discount' => $discount,
            'discountFormatted' => Helper::formatPrice($discount),
        ];
    }
}
