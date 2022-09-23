@extends('layouts.app')

@php
$siteLogo = setting('site.logo');
$logo = $siteLogo ? Voyager::image($siteLogo) : '/img/logo.png';
$siteTitle = setting('site.title');
$seoReplacements = [
    'name' => $category->getTranslatedAttribute('name'),
    'products_quantity' => $category->products_quantity,
    'min_price' => Helper::formatPrice($category->min_price),
    'max_price' => Helper::formatPrice($category->max_price),
    'year' => date('Y'),
];
@endphp

@section('seo_title', $category->getTranslatedAttribute('seo_title') ?: Helper::seo('category', 'seo_title', $seoReplacements))
@section('meta_description', $category->getTranslatedAttribute('meta_description') ?: Helper::seo('category', 'meta_description', $seoReplacements))
@section('meta_keywords', $category->getTranslatedAttribute('meta_keywords') ?: Helper::seo('category', 'meta_keywords', $seoReplacements))
@section('body_class', 'parent-category-page')

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container">
        <x-banner-category type="category_top" :category-id="$category->id"></x-banner-category>
    </div>

    <section class="category">
        <div class="container">
            <h1>{{ $category->getTranslatedAttribute('h1_name') ?: Helper::seo('category', 'h1_name', $seoReplacements) }}</h1>
            <div class="row category-wrap">
                <div class="col-lg-20 col-12 d-none d-lg-block">
                    <aside class="sidebar sticky-top">

                        <x-sidebar-categories :active-category-id="$category->id"></x-sidebar-categories>

                        @if (!$categoryBrands->isEmpty())
                        <div class="mb-4">
                            <h4 class="mb-3">{{ __('main.brands') }}</h4>
                            <ul class="sidebar-nav__list mb-3">
                                @foreach ($categoryBrands as $brand)
                                <li>
                                    <a href="{{ route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $category->getTranslatedAttribute('slug') ?? $category->slug]) }}">{{ $brand->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                            <a href="javascript:;" data-toggle="more-link" data-max="520">
                                <span>{{ __('main.more') }}</span>
                                <svg width="12" height="12" fill="#666">
                                    <use xlink:href="#arrow-down"></use>
                                </svg>
                            </a>
                        </div>
                        @endif

                    </aside>
                </div>
                <div class="col-lg-80 col-12">
                    <article class="category-content">
                        <div class="text-block">
                            <p>{{ $category->getTranslatedAttribute('description') ?: Helper::seo('category', 'description', $seoReplacements) }}</p>
                        </div>
                        <div class="row categories-wrap">
                            @foreach ($subcategories as $subcategory)
                            <div class="col-lg-20 col-4 categories-item__parent">
                                @include('partials.category_one', ['category' => $subcategory])
                            </div>
                            @endforeach
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <x-banner-category type="category_bottom" :category-id="$category->id"></x-banner-category>
    </div>

    <x-bestseller-products></x-bestseller-products>

    <section class="about text-block">
        <div class="container">
            {!! $category->getTranslatedAttribute('body') ?: Helper::seo('category', 'body', $seoReplacements) !!}
        </div>
    </section>

</main>

@if (!$subcategories->isEmpty())
<div class="category-menu" data-target-menu="category-menu">
    <div class="category-menu__header">
        <button type="button" data-toggle="menu-close">
            <svg width="24" height="24" fill="#333">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ $logo }}" alt="{{ $siteTitle }}" class="img-fluid">
            </a>
        </div>
    </div>
    <div class="category-menu__content">
        <div class="category-menu__body">
            <ul class="category-menu__list">
                @foreach ($subcategories as $subcategory)
                <li>
                    <a href="{{ $subcategory->url }}" class="text-uppercase">
                        <span>{{ $subcategory->getTranslatedAttribute('name') }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

@endsection
