@extends('layouts.app')

@section('seo_title', $category->getTranslatedAttribute('seo_title') ?: $category->getTranslatedAttribute('name'))
@section('meta_description', $category->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $category->getTranslatedAttribute('meta_keywords'))

@section('content')

@include('partials.page_top', ['title' => $category->getTranslatedAttribute('name'), 'bg' => $category->bg])

<section class="section zigzag">
    <div class="container">
        <div class="zigzag__in mt-70">
            @foreach ($products as $product)
                @include('partials.zigzag_product_one')
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        {!! $links !!}
    </div>
    <br>
    <br>
</section>

@can('edit', $category)
<div class="my-4">
    <a href="{{ url('admin/categories/' . $category->id . '/edit') }}" class="btn btn-lg btn-primary"
        target="_blank">Редактировать (ID: {{ $category->id }})</a>
</div>
@endcan

@endsection

@section('scripts')

@endsection
