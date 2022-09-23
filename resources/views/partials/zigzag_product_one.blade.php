<div class="post__box">
    <div class="post">
        <div class="post__photo">
            <img src="{{ $product->medium_img }}" alt="{{ $product->getTranslatedAttribute('name') }}" />
        </div>
        <div class="post__half" data-aos="zoom-out">
            <div class="post__content">
                <h3 class="post__name">{{ $product->getTranslatedAttribute('name') }}</h3>
                <p class="post__text">{{ $product->getTranslatedAttribute('description') }}</p>
                <a href="{{ $product->url }}" class="post__link">
                    <span>
                        <svg>
                            <use xlink:href="#link-arrow"></use>
                        </svg>
                    </span>
                    <p>Learn more</p>
                </a>
            </div>
        </div>
    </div>
</div>
