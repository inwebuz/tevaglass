<section class="section advantages">
    <div class="container">
        <div class="advantages__head">
            <div class="heading" data-aos="fade-right">
                <b>02</b>
                <p>OUR ADVANTAGES</p>
            </div>
            <a href="{{ route('about') }}" class="btn btn--outlined btn--md" data-aos="fade-left">Learn more</a>
        </div>
        <div class="advantages__in">
            @foreach ($advantages as $key => $advantage)
            <div class="advantages-card__box" data-aos="fade-up" data-aos-delay="0">
                <div class="advantages-card">
                    <img src="{{ $advantage->img }}" alt="{{ $advantage->getTranslatedAttribute('name') }}" />
                    <h3>{{ $advantage->getTranslatedAttribute('name') }}</h3>
                    <p>{{ $advantage->getTranslatedAttribute('description') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
