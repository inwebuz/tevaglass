@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'bg' => $page->bg])

<x-about></x-about>

<x-random-products></x-random-products>

@can('edit', $page)
    <div class="my-4">
        <a href="{{ url('admin/pages/' . $page->id . '/edit') }}" class="btn btn-lg btn-primary"
            target="_blank">Редактировать (ID: {{ $page->id }})</a>
    </div>
@endcan

@endsection
