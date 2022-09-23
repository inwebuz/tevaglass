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
        <div class="text-block">
            {!! $page->getTranslatedAttribute('body') !!}
        </div>
    </div>

	<div class="container">
        @can('edit', $page)
            <div class="my-4">
                <a href="{{ url('admin/pages/' . $page->id . '/edit') }}" class="btn btn-lg btn-primary"
                    target="_blank">Редактировать (ID: {{ $page->id }})</a>
            </div>
        @endcan
    </div>

</main>

@endsection
