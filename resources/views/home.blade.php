@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))
@section('body_class', 'home-page')

@section('content')

    @include('partials.alerts')

    <!-- hero -->
    <section class="hero" style="background: url({{ $homePageText->img }}) center center no-repeat; background-size: cover;">
        <div class="container">
            <div class="hero__in">
                <div class="hero__content" data-aos="fade-up">
                    <h1 class="hero__title">{{ $homePageText->name }}</h1>
                    <p class="hero__text">{{ $homePageText->description }}</p>
                    <a href="{{ route('about') }}" class="btn btn--md btn--filled">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <x-about></x-about>

    <x-advantages></x-advantages>

    <x-business-areas></x-business-areas>


    <!-- projects -->
    <section class="section projects">
        <div class="container">
            <div class="head">
                <div class="heading" data-aos="fade-right">
                    <b>04</b>
                    <p>Portfolio</p>
                </div>
                <a href="{{ route('portfolio') }}" class="head__link" data-aos="fade-left">All Works</a>
            </div>
        </div>
        <div class="projects__in">
            <div id="mry-dynamic-content" class="transition-fade">
                <div class="mry-content-frame" id="scroll">
                    <div class="swiper-container mry-main-slider">
                        <div class="swiper-wrapper">
                            @foreach ($projects as $project)
                            <div class="swiper-slide">
                                <!-- project -->
                                <div class="mry-project-slider-item">
                                    <div class="mry-project-frame mry-project-half">
                                        <div class="mry-cover-frame">
                                            <img class="mry-project-cover mry-position-right" src="{{ $project->img }}" alt="{{ $project->getTranslatedAttribute('name') }}" data-swiper-parallax="500" data-swiper-parallax-scale="1.4" />
                                            <div class="mry-cover-overlay"></div>
                                            <div class="mry-loading-curtain"></div>
                                        </div>
                                        <div class="mry-main-title-frame">
                                            <div class="container">
                                                <div class="mry-main-title" data-swiper-parallax-x="30%" data-swiper-parallax-scale=".7" data-swiper-parallax-opacity="0" data-swiper-parallax-duration="1000" >
                                                    <small>{{ $project->getTranslatedAttribute('short_info') }}</small>
                                                    <span class="mry-main-title-frame__title">
                                                        <a href="{{ $project->url }}">{{ $project->getTranslatedAttribute('name') }}</a>
                                                    </span>
                                                    <p>{{ $project->getTranslatedAttribute('description') }}</p>
                                                    <ul class="mry-main-title-frame__list">
                                                        <li>
                                                            <a href="{{ $project->url }}" class="btn btn--filled btn--md">
                                                                <span>MORE</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <span class="mry-main-title-frame__link">
                                                                <a href="{{ route('portfolio') }}">All Works</a>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- project end -->
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mry-slider-pagination-frame">
                        <div class="mry-slider-pagination"></div>
                    </div>

                    <div class="mry-slider-nav-panel">
                        <div class="container">
                            <div class="mry-slider-progress-bar-frame">
                                <div class="mry-slider-progress-bar">
                                    <div class="mry-progress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mry-slider-arrows">
                            <div class="mry-label">Navigation</div>
                            <div class="mry-button-prev mry-magnetic-link">
                                <span class="mry-magnetic-object">Prev</span>
                            </div>
                            <div class="mry-button-next mry-magnetic-link">
                                <span class="mry-magnetic-object">Next</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-random-products show-header="true"></x-random-products>

    <x-news></x-news>

@endsection
