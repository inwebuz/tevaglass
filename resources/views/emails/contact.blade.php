<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <title>Контактная форма</title>
</head>

<body style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;">
    <h1>
        {{ setting('site.title') }} - Контактная форма
    </h1>

    <p>
        <strong>Имя:</strong> {{ $contact->name }} <br />
        <strong>Телефон:</strong> {{ $contact->phone }} <br />
        <strong>Email:</strong> {{ $contact->email }} <br />
        <strong>Сообщение:</strong> {{ $contact->message }} <br />
        <strong>Форма:</strong> {{ $contact->type_title }} <br />
        @if($product)
        <strong>Товар:</strong> <a href="{{ $product->url }}" target="_blank">{{ $product->name }}</a> <br />
        @endif
        @if($product)
        <strong>Товар:</strong> <a href="{{ $product->url }}" target="_blank">{{ $product->name }}</a> <br />
        @endif
        @if($category)
        <strong>Категория:</strong> <a href="{{ $category->url }}" target="_blank">{{ $category->name }}</a> <br />
        @endif
    </p>
</body>

</html>
