{{-- <div class="page-top" @if(!empty($bg)) style="background-image: url({{ $bg }})" @endif>
    <div class="container">
        @include('partials.breadcrumbs')
        <h1 class="page-header">{{ $title ?? $page->title ?? '' }}</h1>
    </div>
    @include('partials.waves')
</div> --}}

<section class="intro" style="background: url({{ $bg ?: asset('img/intro-products.jpg') }})">
    <div class="container">
        <div class="intro__in">
            <h1 class="intro__title">{{ $title ?? '' }}</h1>
            @include('partials.breadcrumbs')
        </div>
    </div>
</section>
