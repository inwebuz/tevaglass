@if (!$discountedProducts->isEmpty())
    <section class="products">
        <div class="container">
            <div class="content-top">
                <h2>{{ __('main.hurry_up_to_buy') }}</h2>
                <a href="{{ route('sale') }}" class="more-link" data-mobile-text="{{ __('main.all') }}">
                    <span>{{ __('main.view_all') }}</span>
                    <svg width="18" height="18" fill="#6b7279">
                        <use xlink:href="#arrow"></use>
                    </svg>
                </a>
            </div>
            <div class="row products-wrap">
                @foreach ($discountedProducts as $product)
                    <div class="col-lg-2 col-sm-4 col-6 product-card__parent">
                        @include('partials.product_one')
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
