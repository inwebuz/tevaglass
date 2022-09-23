<b>{{ setting('site.title') }} - Отклик на вакансию</b>
<b>Имя:</b> {{ $request->name }}
<b>Телефон:</b> {{ $request->phone }}
<b>Сообщение:</b> {{ $request->message }}
<b>Вакансия:</b> <a href="{{ $vacancy->url }}">{{ $vacancy->name }}</a>
