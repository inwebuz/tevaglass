@if (!$brands->isEmpty())
<section class="brands">
    <div class="container">
        <div class="content-top">
            <h2>{{ __('main.brands') }}</h2>
            <a href="{{ route('brands.index') }}" class="more-link" data-mobile-text="Все">
                <span>{{ __('main.all') }}</span>
                <svg width="18" height="18" fill="#6b7279">
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
        </div>
        <div class="brands-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper row">
                    @foreach ($brands as $key => $brand)
                    <div class="swiper-slide col-lg-2 col-4">
                        <div class="radius-12 overflow-hidden">
                            @include('partials.brand_one')
                        </div>
                    </div>
                    @endforeach
                </div>
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
    </div>
</section>
@endif
