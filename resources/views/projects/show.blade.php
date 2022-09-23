@extends('layouts.app')

@section('seo_title', $project->getTranslatedAttribute('seo_title') ?: $project->getTranslatedAttribute('name'))
@section('meta_description', $project->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $project->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $project->getTranslatedAttribute('name'), 'bg' => $project->bg])

<section class="section">
    <div class="container">
        <div class="static">
            <h2>{{ $project->getTranslatedAttribute('description') }}</h2>
            <div>
                {!! $project->body !!}
            </div>
        </div>
    </div>
</section>

<x-random-products :products="$products"></x-random-products>

@can('edit', $project)
    <div class="my-4">
        <a href="{{ url('admin/projects/' . $project->id . '/edit') }}" class="btn btn-lg btn-primary"
            target="_blank">Редактировать (ID: {{ $project->id }})</a>
    </div>
@endcan

@endsection
