<section class="section about">
    <div class="container">
        <div class="about__in">
            <div class="about__half" data-aos="fade-right">
                <div class="about__photo">
                    <img src="{{ $page->img }}" alt="{{ $page->name }}" class="about__img" />
                    <h3>{{ $siteTitle }}</h3>
                    <img src="/img/frame.svg" class="about__frame" />
                </div>
            </div>
            <div class="about__content" data-aos="fade-left">
                <div class="heading heading--w250">
                    <b>01</b>
                    <p>About company</p>
                </div>
                <div class="about__info">
                    <h2 class="about__title">The best for you!</h2>
                    <div class="about__text">
                        <p>
                            {{ $page->description }}
                        </p>
                    </div>
                </div>
                <img src="/img/pentagon.svg" class="about__pentagon" />
            </div>
        </div>

        <x-principles></x-principles>

    </div>
</section>
