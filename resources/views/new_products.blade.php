@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@php
    $title = $page->getTranslatedAttribute('name');
    if ($category) {
        $title .= ' - ' . $category->getTranslatedAttribute('name');
    }
@endphp


<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container py-4 py-lg-5">

        <h1>{{ $title }}</h1>

        @if(!$products->isEmpty())

            <div class="row products-wrap">
                @foreach ($products as $product)
                    <div class="col-lg-20 col-12 product-card__parent mb-4">
                        @include('partials.product_one')
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {!! $links !!}
            </div>

        @else
            <div class="text-center lead">
                {{ __('main.no_products') }}
            </div>
        @endif

    </div>
</main>

@endsection
