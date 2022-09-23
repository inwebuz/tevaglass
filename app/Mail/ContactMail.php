<?php

namespace App\Mail;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Contact;
use App\Models\Product;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;
    protected $product;
    protected $category;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Product $product = null, Category $category = null)
    {
        $this->contact = $contact;
        if ($product) {
            $this->product = $product;
        }
        if ($category) {
            $this->category = $category;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact', ['contact' => $this->contact, 'product' => $this->product, 'category' => $this->category]);
    }
}

