<b>{{ setting('site.title') }} - Контактная форма</b>
<b>Имя:</b> {{ $contact->name }}
<b>Телефон:</b> {{ $contact->phone }}
<b>E-mail:</b> {{ $contact->email }}
<b>Сообщение:</b> {{ $contact->message }}
<b>Форма:</b> {{ $contact->type_title }}
@if($product)
<b>Товар:</b> <a href="{{ $product->url }}">{{ $product->name }}</a>
@endif
@if($category)
<b>Категория:</b> <a href="{{ $category->url }}">{{ $category->name }}</a>
@endif
