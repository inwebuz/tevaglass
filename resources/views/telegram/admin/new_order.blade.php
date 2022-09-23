<b>{{ setting('site.title') }} - Новый заказ</b>

ID: {{ $order->id }}
Имя: {{ $order->name }}
Телефон: {{ $order->phone_number }}
E-mail: {{ $order->email }}
Адрес: {{ $order->address_line_1 }}
Сообщение: {{ $order->message }}
Способ оплаты: {{ $order->payment_method_title }}
{{-- Тип заказа: {{ $order->type_title }} --}}
@if($order->shipping_name) Имя получателя: {{ $order->shipping_name }} @endif
@if($order->shipping_phone_number) Телефон получателя: {{ $order->shipping_phone_number }} @endif
@if($order->shipping_address) Адрес получателя: {{ $order->shipping_address }} @endif

Продукты:
@foreach($order->orderItems as $item)
<a href="{{ $item->product->url ?? '' }}">{{ $item->quantity }} x {{ $item->name }}</a> - {{ Helper::formatPrice($item->total) }}
@endforeach

Итого: {{ Helper::formatPrice($order->total) }}

<a href="{{ $url }}">Детали</a>
