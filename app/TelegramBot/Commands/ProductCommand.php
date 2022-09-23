<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\Models\Category;
use App\Helpers\Helper;
use App\Models\Product;
use App\TelegramBot\Traits\CallbackData;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Request;

class ProductCommand extends UserCommand
{
    use CallbackData;

    /**
     * @var string
     */
    protected $name = 'product';

    /**
     * @var string
     */
    protected $description = 'Просмотр товара';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var array
     */
    private $callbackdata;

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $text = trim($message->getText(true));

        // parse data
        $this->callbackdata = $this->parseCallbackData($text);

        // get keyboard
        if (isset($this->callbackdata['product_show'])) {
            // show subcategories
            $product_id = (int)$this->callbackdata['product_show'];
            $product = Product::findOrFail($product_id);

            // send photo
            Request::sendPhoto([
                'chat_id' => $chat_id,
                'photo' => $product->img,
                'caption' => $product->telegram_name,
                'disable_notification' => true,
            ]);

            $returnCategory = isset($this->callbackdata['return_category']) ? $this->callbackdata['return_category'] : null;
            $returnPage = isset($this->callbackdata['return_page']) ? $this->callbackdata['return_page'] : null;

            // send message
            $sendMessage = 'Товар: ' . $product->telegram_name . PHP_EOL;
            $sendMessage .= 'Цена: ' . Helper::formatPrice($product->current_price) . PHP_EOL;

            $keyboard = self::keyboard($product, $returnCategory, $returnPage);
        } else {
            // error
            return Request::emptyResponse();
        }

        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => $sendMessage,
            'reply_markup' => $keyboard,
        ]);
    }

    public static function keyboard(Product $product, $returnCategory = null, $returnPage = null)
    {
        $buttons = [];
        $buttons[] = [
            'text' => 'Заказать',
            'callback_data' => 'order_product:' . $product->id,
        ];
        if ($returnCategory && $returnPage) {
            $buttons[] = [
                'text' => 'Назад',
                'callback_data' => 'category_products:' . $returnCategory . '|page:' . $returnPage,
            ];
        }

        $inline_keyboard = new InlineKeyboard(...[$buttons]);

        return $inline_keyboard;
    }
}
