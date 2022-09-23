@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'bg' => $page->bg])

<section class="section zigzag">
    <div class="container">
        <div class="zigzag__in">
            @foreach($projects as $project)
            <div class="portfolio">
                <div class="portfolio__content" data-aos="fade-up">
                    <h2 class="portfolio__title">{{ $project->getTranslatedAttribute('name') }}</h2>
                    <p class="portfolio__text">{{ $project->getTranslatedAttribute('description') }}</p>
                    <a href="{{ $project->url }}" class="portfolio__link">
                        <span>
                            <svg>
                                <use xlink:href="#link-arrow"></use>
                            </svg>
                        </span>
                        <p>Learn more</p>
                    </a>
                </div>
                <div class="portfolio__half">
                    <div class="portfolio__photo">
                        <img src="{{ $project->medium_img }}" alt="{{ $project->getTranslatedAttribute('name') }}" />
                    </div>
                    <img src="/img/triangle.svg" alt="{{ $project->getTranslatedAttribute('name') }}" class="portfolio__frame" data-aos="fade-up" />
                    <div class="portfolio__parts" data-aos="zoom-in">
                        {{ $project->getTranslatedAttribute('short_info') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {!! $links !!}

    </div>
</section>

@endsection
