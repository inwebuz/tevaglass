@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'bg' => $page->bg])

<section class="section">
    <div class="container">
        <div class="cards">
            @foreach ($categories as $category)
            <div class="card__box">
                <div class="card">
                    <div class="card__photo">
                        <img src="{{ $category->medium_img }}" alt="{{ $category->getTranslatedAttribute('name') }}" />
                    </div>
                    <div class="card__content">
                        <h3>{{ $category->getTranslatedAttribute('name') }}</h3>
                        <p>{{ $category->getTranslatedAttribute('description') }}</p>
                    </div>
                    <div class="card__cover">
                        <a href="{{ $category->url }}" class="btn btn--outlined-text-white btn--md">more</a>
                    </div>
                    <img src="/img/frame.svg" class="card__frame" />
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('after_footer_blocks')

@endsection

@section('scripts')

@endsection

@section('styles')

@endsection
