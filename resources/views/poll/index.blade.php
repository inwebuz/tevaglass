@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')


<section class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="order-lg-2 col-lg-9 col-xl-9 main-block">

                <section class="content-block">
                    <x-top-search></x-top-search>
                </section>

                @include('partials.breadcrumbs')

                <h1 class="main-header mt-3">{{ $page->getTranslatedAttribute('name') }}</h1>

                <div class="publications-list">
                    @foreach($polls as $key => $poll)
                        <div class="standard-shadow-white-box">
                            <h4 class="mb-0">
                                <a href="{{ $poll->url }}" class="black-link">{{ $poll->getTranslatedAttribute('question') }}</a>
                            </h4>
                        </div>
                    @endforeach
                </div>

                <div class="pb-5"></div>

                {{--<div class="text-block mt-5">
                    {!! $page->body !!}
                </div>--}}

            </div>
            <div class="order-lg-1 col-lg-3 col-xl-3 side-block">

                @include('partials.sidebar')

            </div>
        </div>


    </div>
</section>

<x-principles></x-principles>

@endsection
