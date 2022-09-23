@extends('layouts.app')

@php
$seoReplacements = [
    'name' => $brand->getTranslatedAttribute('name'),
    'products_quantity' => $brand->products_quantity,
    'year' => date('Y'),
];
@endphp

@section('seo_title', $brand->getTranslatedAttribute('seo_title') ?: Helper::seo('brand', 'seo_title', $seoReplacements))
@section('meta_description', $brand->getTranslatedAttribute('meta_description') ?: Helper::seo('brand', 'meta_description', $seoReplacements))
@section('meta_keywords', $brand->getTranslatedAttribute('meta_keywords') ?: Helper::seo('brand', 'meta_keywords', $seoReplacements))

@section('content')

<main class="main">

    <div class="container">
        @can('edit', $brand)
        <div class="my-4">
            <a href="{{ url('admin/brands/' . $brand->id . '/edit') }}" class="btn btn-lg btn-primary"
                target="_blank">Редактировать (ID: {{ $brand->id }})</a>
        </div>
        @endcan
    </div>

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <section class="category">
        <div class="container">
            <h1>{{ $brand->getTranslatedAttribute('h1_name') ?: Helper::seo('brand', 'h1_name', $seoReplacements) }}</h1>

            <div class="row category-wrap">
                <div class="col-lg-20 col-12">
                    <aside class="sidebar sticky-top catalog-sidebar">

                        <x-sidebar-categories :brand-id="$brand->id"></x-sidebar-categories>

                    </aside>
                </div>
                <div class="col-lg-80 col-12">
                    <article class="category-content">
                        <div class="text-block">
                            <p>{{ $brand->getTranslatedAttribute('description') ?: Helper::seo('brand', 'description', $seoReplacements) }}</p>
                        </div>

                        <div class="row products-wrap">
                            @forelse ($products as $product)
                            <div class="col-lg-3 col-md-4 col-6 product-item__parent">
                                @include('partials.product_one')
                            </div>
                            @empty
                            @php
                            $noProductsText = Helper::staticText('no_products_text')->getTranslatedAttribute('description') ?? '';
                            @endphp
                            <div class="col-12 text-center">
                                <div class="p-4">
                                    {!! $noProductsText !!}
                                </div>
                            </div>
                            @endforelse
                        </div>

                        @if(!$products->isEmpty())
                        <div class="content-bottom">

                            {!! $links !!}

                        </div>
                        @endif
                    </article>
                </div>
            </div>

        </div>
    </section>

    <section class="about text-block">
        <div class="container">
            {!! $brand->getTranslatedAttribute('body') ?: Helper::seo('brand', 'body', $seoReplacements) !!}
        </div>
    </section>
</main>

@endsection
