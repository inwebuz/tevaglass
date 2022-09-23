@if (!$publications->isEmpty())
<section class="section">
    <div class="container">
        <div class="head">
            <div class="heading" data-aos="fade-right">
                <b>06</b>
                <p>Latest news</p>
            </div>
            <a href="{{ route('news.index') }}" class="head__link" data-aos="fade-left">All News</a>
        </div>
        <div class="news mt-70">
            @foreach ($publications as $publication)
                @include('partials.publication_one')
            @endforeach
        </div>
    </div>
</section>
@endif
