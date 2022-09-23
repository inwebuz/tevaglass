<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Helpers\Helper;
use App\Mail\ContactMail;
use App\Mail\UserRegisteredMail;
use App\Services\TelegramService;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;

class ContactController extends Controller
{
    /**
     * Show contacts page
     */
    public function index()
    {
        $locale = app()->getLocale();
        $page = Page::where('id', 2)->withTranslation($locale)->firstOrFail(); // contacts page
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.nav.contacts'), route('contacts'), LinkItem::STATUS_INACTIVE));
        $address = Helper::staticText('contact_address', 300)->getTranslatedAttribute('description');
        return view('contacts', compact('breadcrumbs', 'page', 'address'));
    }

    /**
     * Send contact email
     *
     * @return json
     */
    public function send(Request $request)
    {
        $captchaKey = $request->input('captcha_key', '');
        $data = $request->validate([
            // 'captcha_key' => 'required',
            // 'captcha' => 'required|captcha_api:' . $captchaKey . ',flat',
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:191',
            'message' => 'max:50000',
            'type' => '',
        ]);

        $telegram_chat_id = config('services.telegram.chat_id');
        if (empty($data['type']) || !array_key_exists($data['type'], Contact::types())) {
            $data['type'] = Contact::TYPE_CONTACT;
        }

        // save to database
        $contact = Contact::create($data);
        $contact->type = $data['type'];
        $contact->info = '';

        $category = null;
        $product = null;

        if (isset($request->product_id)) {
            $product = Product::find((int)$request->product_id);
            if ($product) {
                $contact->info = '<a href="' . $product->url . '" target="_blank" >' . $product->name . '</a>';
                if ($product->in_stock == 0 /*&& $product->isAvailableFromPartner()*/) {
                    $telegram_chat_id = config('services.telegram.partner_chat_id');
                }
            }
        } elseif (isset($request->category_id)) {
            $category = Category::find((int)$request->category_id);
            if ($category) {
                $contact->info = '<a href="' . $category->url . '" target="_blank" >' . $category->name . '</a>';
            }
        }
        $contact->save();

        // send telegram
        $telegramMessage = view('telegram.admin.contact', compact('contact', 'product', 'category'))->render();
        $telegramService = new TelegramService();
        $telegramService->sendMessage($telegram_chat_id, $telegramMessage, 'HTML');

        // send email
        // Mail::to(setting('contact.email'))->send(new ContactMail($contact, $product));

        // return redirect()->route('home', ['#contact-form'])->withSuccess(__('home.contact_message_success'));

        $data = [
            'message' => __('main.form.contact_form_success'),
        ];

        return response()->json($data);
    }
}
