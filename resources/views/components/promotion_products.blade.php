@if (!$promotionProducts->isEmpty())
<section class="products">
    <div class="container">
        <div class="content-top">
            <h2>{{ __('main.promotions_and_discounts') }}</h2>
            <a href="{{ route('promotional-products') }}" class="more-link" data-mobile-text="{{ __('main.all') }}">
                <span>{{ __('main.view_all') }}</span>
                <svg width="18" height="18" fill="#6b7279">
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
        </div>
        <div class="row products-wrap">
            <div class="col-lg-40 col-12 mb-3 mb-lg-0">
                <div class="promotions-swiper swiper-container radius-10">
                    <div class="swiper-wrapper">
                        @foreach ($slides as $slide)
                        <div class="swiper-slide">
                            <div class="promotions-swiper__item radius-10"
                                style="background-image: url('{{ $slide->img }}')">
                                <h2>{{ $slide->getTranslatedAttribute('name') }}</h2>
                                @if ($slide->getTranslatedAttribute('button_text') && $slide->getTranslatedAttribute('url'))
                                    <a href="{{ $slide->getTranslatedAttribute('url') }}" class="btn sm radius-4">{{ $slide->getTranslatedAttribute('button_text') }}</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-60 col-12">
                <div class="products-swiper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper row">
                            @foreach ($promotionProducts as $product)
                            <div class="swiper-slide product-item__parent col-md-4 col-6">
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
        </div>
    </div>
</section>
@endif
