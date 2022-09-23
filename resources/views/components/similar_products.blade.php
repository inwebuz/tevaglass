@if (!$products->isEmpty())
<section class="products">
    <div class="container">
        <h2>{{ __('main.similar_products') }}</h2>
        <div class="products-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper row">
                    @foreach ($products as $product)
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
