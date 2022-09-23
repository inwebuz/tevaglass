@extends('layouts.app')

@section('seo_title', $publication->getTranslatedAttribute('seo_title') ?: $publication->getTranslatedAttribute('name'))
@section('meta_description', $publication->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $publication->getTranslatedAttribute('meta_keywords'))
{{-- @section('body_class', 'no-sidebar-page') --}}

@section('content')

@include('partials.page_top', ['title' => $publication->getTranslatedAttribute('name'), 'bg' => $publication->bg])

<section class="section">
    <div class="container">
        <div class="static__photo">
            <img src="{{ $publication->img }}" alt="{{ $publication->getTranslatedAttribute('name') }}" />
        </div>
        <ul class="static__info">
            <li>
                {{ $publication->author }}
            </li>
            <li>
                <span>{{ Helper::formatDate($publication->created_at, true) }}</span>
            </li>
        </ul>
        <div class="static">
            <h2>{{ $publication->getTranslatedAttribute('description') }}</h2>
            <div>
                {!! $publication->body !!}
            </div>
        </div>
        <a href="{{ route('news.index') }}" class="btn btn--outlined btn--md">back to news</a>
    </div>
</section>

@can('edit', $publication)
    <div class="my-4">
        <a href="{{ url('admin/publications/' . $publication->id . '/edit') }}" class="btn btn-lg btn-primary"
            target="_blank">Редактировать (ID: {{ $publication->id }})</a>
    </div>
@endcan

@endsection
