<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Store;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:191',
            'email' => 'nullable|max:191',
            'phone' => 'required|max:191',
            'message' => 'nullable|max:50000',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $telegram_chat_id = config('services.telegram.chat_id');
        $data['type'] = Contact::TYPE_CONTACT;

        // save to database
        $contact = Contact::create($data);

        $category = null;
        $product = null;

        if (!empty($data['product_id'])) {
            $product = Product::find($data['product_id']);
        }
        if (!empty($data['category_id'])) {
            $category = Category::find($data['category_id']);
        }
        $contact->save();

        // send telegram
        $telegramMessage = view('telegram.admin.contact', compact('contact', 'product', 'category'))->render();
        $telegramService = new TelegramService();
        $telegramService->sendMessage($telegram_chat_id, $telegramMessage, 'HTML');

        // send email
        try {
            Mail::to(setting('contact.email'))->send(new ContactMail($contact, $product, $category));
        } catch (Throwable $e) {
            // Log::debug($e->getMessage());
        }

        return response()->json([
            'message' => __('main.form.contact_form_success'),
        ]);
    }
}
