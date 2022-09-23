@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container py-4 py-lg-5">

        <h1>{{ $page->getTranslatedAttribute('name') }}</h1>

        @if(!$brands->isEmpty())
            <div class="brands-list row">
                @foreach($brands as $brand)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="overflow-hidden radius-12 mb-4">
                            @include('partials.brand_one')
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="lead">
                {{ __('main.no_brands') }}
            </div>
        @endif



    </div>
</main>

@endsection
