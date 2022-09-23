<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Page;
use App\Rules\CurrentPassword;
use App\Services\TelegramService;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show'), LinkItem::STATUS_INACTIVE));

        $cartQuantity = app('cart')->getTotalQuantity();
        $wishlistQuantity = app('wishlist')->getTotalQuantity();
        $compareQuantity = app('compare')->getTotalQuantity();
        $ordersQuantity = Order::where('user_id', $user->id)->count();

        $notifications = $user->notifications()->new()->count();

        return view('profile.show', compact('breadcrumbs', 'user', 'cartQuantity', 'wishlistQuantity', 'compareQuantity', 'ordersQuantity', 'notifications'));
    }

    public function edit()
    {
        $user = Auth::user();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.edit'), route('profile.edit'), LinkItem::STATUS_INACTIVE));
        return view('profile.edit', compact('breadcrumbs', 'user'));
    }

    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:190'],
            // 'phone_number' => ['max:190'],
            'address' => ['max:5000'],
            'avatar' => ['image', 'max:1024'],
        ]);

        $authUser = auth()->user();
        if (!empty($data['avatar'])) {
            if ($authUser->avatar) {
                Storage::disk('public')->delete($authUser->avatar);
            }
            Helper::storeImage($authUser, 'avatar', 'users');
            unset($data['avatar']);
        }

        $authUser->update($data);

        // Session::flash('message', __('main.profile_saved'));
        // return redirect()->back();

        return redirect()->route('profile.show')->withSuccess(__('main.profile_saved'));
    }

    public function password(Request $request)
    {
        $data = $this->validate($request, [
            'current_password' => ['required', new CurrentPassword],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        Auth::user()->update([
            'password' => Hash::make($data['password']),
        ]);
        Session::flash('pmessage', __('main.password_saved'));
        return redirect()->back();
    }

    public function orders()
    {
        $user = Auth::user();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.orders'), route('profile.orders'), LinkItem::STATUS_INACTIVE));
        $orders = $user->orders()->with('orderItems.product')->latest()->paginate(20);
        return view('profile.orders', compact('breadcrumbs', 'user', 'orders'));
    }

    public function requestSellerStatus()
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.become_a_seller'), route('profile.request-seller-status'), LinkItem::STATUS_INACTIVE));

        $user = Auth::user();
        $userApplication = false;
        $errorText = __('main.you_cannot_become_a_seller');
        if ($user->role->name == 'user' || $user->role->name == 'seller') {
            $userApplication = UserApplication::firstOrCreate([
                'type' => UserApplication::TYPE_BECOME_SELLER,
                'user_id' => $user->id,
            ], [
                'status' => UserApplication::STATUS_PENDING,
            ]);
            if ($userApplication->wasRecentlyCreated) {
                Session::flash('message', __('main.request_accepted'));
            }
        }

        $telegram_chat_id = config('services.telegram.chat_id');
        $telegramService = new TelegramService();
        $telegramService->sendMessage($telegram_chat_id, 'Новая заявка - Стать продавцом');

        return view('profile.request_seller_status', compact('userApplication', 'errorText'));
    }

    public function shopEdit(Request $request)
    {
        $shop = auth()->user()->shops()->first();
        if (!$shop) {
            $shop = new Shop();
        }
        return view('profile.shop.edit', compact('shop'));
    }

    public function shopUpdate(Request $request)
    {
        $shop = auth()->user()->shops()->first();
        if (!$shop) {
            abort(404);
        }
        $data = $this->validatedShopData($request);
        $data['status'] = Shop::STATUS_PENDING;
        $shop->update($data);

        Helper::storeImage($shop, 'image', 'shops', Shop::$imgSizes);

        Session::flash('message', __('main.shop_updated') . '. ' . __('main.pending_moderator_review'));
        return redirect()->route('profile.shop.edit');
    }

    protected function validatedShopData(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'image' => ['sometimes', 'image', 'max:1000'],
            'description' => ['max:1000'],
            'phone_number' => ['required'],
            'email' => ['required', 'email', 'max:190'],
            'address' => ['max:1000'],
        ]);
        return $data;
    }

    public function products()
    {
        $user = Auth::user();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.products'), route('profile.products'), LinkItem::STATUS_INACTIVE));
        $shop = $user->shops()->first();
        if (!$shop) {
            $shop = new Shop();
        }
        $products = $shop->products()->latest()->paginate(20);
        return view('profile.products', compact('breadcrumbs', 'user', 'products'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.notifications'), route('profile.notifications.index'), LinkItem::STATUS_INACTIVE));
        $notifications = $user->notifications()->latest()->paginate(20);
        Notification::whereIn('id', $notifications->pluck('id')->toArray())->update(['status' => Notification::STATUS_READ]);
        return view('profile.notification.index', compact('breadcrumbs', 'user', 'notifications'));
    }

    public function notificationsShow(Notification $notification)
    {
        $user = Auth::user();
        if ($notification->user_id != $user->id) {
            abort(403);
        }
        $notification->status = Notification::STATUS_READ;
        $notification->save();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.notifications'), route('profile.notifications.index')));
        return view('profile.notification.show', compact('breadcrumbs', 'user', 'notification'));
    }
}
