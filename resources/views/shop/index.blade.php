@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))
@section('body_class', 'shops-page')

@section('content')

    <!-- slider Area Start-->
    <div class="slider-area ">
        <div class="single-slider slider-height2 d-flex align-items-center" data-background="/images/bg/standard.jpg">
            <div class="container">
                <div class="hero-cap text-center">
                    <h1 class="main-header">{{ $page->getTranslatedAttribute('name') }}</h1>
                    @include('partials.breadcrumbs')
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <section class="shops-list">
        <div class="container">
            @if(!$shops->isEmpty())
                <div class="row">
                    @foreach($shops as $shop)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                            @include('partials.shop_one')
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center lead py-5">
                    {{ __('main.no_shops') }}
                </div>
            @endif
        </div>
    </section>

    <section>
        <div class="container">
            <div class="text-block">
                {!! $page->getTranslatedAttribute('body') !!}
            </div>
        </div>
    </section>


@endsection
