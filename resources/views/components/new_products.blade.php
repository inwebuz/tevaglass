@if (!$newProducts->isEmpty())
    <section class="products">
        <div class="container">
            <div class="content-top">
                <h2>{{ __('main.new_products2') }}</h2>
                <a href="{{ route('new-products') }}" class="more-link" data-mobile-text="{{ __('main.all') }}">
                    <span>{{ __('main.view_all') }}</span>
                    <svg width="18" height="18" fill="#6b7279">
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
            </div>
            <div class="products-swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper row">
                        @foreach ($newProducts as $product)
                        <div class="swiper-slide product-item__parent col-lg-20 col-md-4 col-6">
                            @include('partials.product_one')
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
