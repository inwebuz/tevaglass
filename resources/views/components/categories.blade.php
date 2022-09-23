<section class="categories">
    <div class="container">
        <div class="content-top">
            <h2>{{ __('main.categories') }}</h2>
            <a href="{{ route('categories') }}" class="more-link" data-mobile-text="{{ __('main.all') }}">
                <span>{{ __('main.all_categories') }}</span>
                <svg width="18" height="18" fill="#6b7279">
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
        </div>
        <div class="categories-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                    <div class="swiper-slide col-lg-14_2 col-md-3 col-4">
                        <a href="{{ $category->url }}" class="categories-swiper__item radius-12">
                            <img src="{{ $category->small_img }}" alt="{{ $category->getTranslatedAttribute('name') }}">
                            <b>{{ $category->getTranslatedAttribute('name') }}</b>
                        </a>
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
