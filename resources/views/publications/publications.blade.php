@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'bg' => $page->bg])

<section class="section">
    <div class="container">
        <div class="news">
            @foreach ($publications as $publication)
                @include('partials.publication_one')
            @endforeach
        </div>

        {!! $links !!}
    </div>
</section>

@endsection
