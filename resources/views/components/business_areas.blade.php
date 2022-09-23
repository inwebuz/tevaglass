<section class="section areas">
    <div class="areas-head">
        <div class="container">
            <div class="aread-head__in">
                <div class="heading" data-aos="fade-right">
                    <b>03</b>
                    <p>Business areas</p>
                </div>
                <a href="{{ route('portfolio') }}" class="btn btn--outlined btn--md" data-aos="fade-left">Learn more</a>
            </div>
        </div>
    </div>
    <ul class="areas__in">
        @foreach ($projects as $key => $project)
        <li class="areas__item">
            <div class="areas__box">
                <a href="{{ $project->url }}" class="areas__link" style="background-image: url({{ $project->medium_img }})">
                    <div class="areas__content">
                        <h3>{{ $project->getTranslatedAttribute('name') }}</h3>
                        <p>{{ $project->getTranslatedAttribute('description') }}</p>
                        <span class="btn btn--outlined btn--md">Learn more</span>
                    </div>
                </a>
            </div>
        </li>
        @endforeach
    </ul>
</section>
