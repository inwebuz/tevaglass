@if (!$banners->isEmpty())
<div class="category-b-slider swiper-container">
    <div class="swiper-wrapper">
        @foreach ($banners as $banner)
        <div class="swiper-slide">
            <a href="{{ $banner->getTranslatedAttribute('url') }}" class="d-block radius-10 overflow-hidden mt-2 mt-lg-3">
                <img src="{{ $banner->img }}" alt="{{ $banner->getTranslatedAttribute('name') }}" class="img-fluid">
            </a>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-prev">
        <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
            <use xlink:href="#arrow-prev"></use>
        </svg>
    </div>
    <div class="swiper-button-next">
        <svg width="18" height="18" fill="rgba(0, 0, 0, .3)">
            <use xlink:href="#arrow-next"></use>
        </svg>
    </div>
</div>
@endif
