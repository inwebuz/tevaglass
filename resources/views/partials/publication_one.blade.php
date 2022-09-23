{{-- <a href="{{ $publication->url }}" class="article-item">
    <div class="article-item__body radius-6">
        <img src="{{ $publication->medium_img }}" alt="{{ $publication->name }}" class="img-fluid">
    </div>
    <div class="article-item__footer">
        <strong>{{ $publication->name }}</strong>
    </div>
</a> --}}

<div class="news__box" data-aos="fade-up">
    <div class="news__item">
        <a href="{{ $publication->url }}" class="news__photo">
            <img src="{{ $publication->medium_img }}" alt="{{ $publication->getTranslatedAttribute('name') }}" />
        </a>
        <div class="news__content">
            <ul class="news__info">
                <li>
                    <a href="{{ $publication->url }}">{{ $publication->author }}</a>
                </li>
                <li>
                    <span>{{ Helper::formatDate($publication->created_at, true) }}</span>
                </li>
            </ul>
            <a href="{{ $publication->url }}" class="news__title">{{ $publication->getTranslatedAttribute('name') }}</a>
            <a href="{{ $publication->url }}" class="btn btn--outlined btn--md">Learn more</a>
        </div>
    </div>
</div>
