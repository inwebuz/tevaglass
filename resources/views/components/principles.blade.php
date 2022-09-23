<div class="about__cards">
    @foreach ($principles as $key => $principle)
    <div class="about-card__box" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
        <div class="about-card">
            <img src="{{ $principle->img }}" alt="{{ $principle->getTranslatedAttribute('name') }}" />
            <b>{{ $principle->getTranslatedAttribute('name') }}</b>
            <p>{{ $principle->getTranslatedAttribute('description') }}</p>
            @if ($principle->url)
            <a href="{{ $principle->url }}" class="btn btn--sm btn--outlined">more</a>
            @endif
        </div>
    </div>
    @endforeach
</div>
