<section class="section zigzag">
    <div class="container">
        @if ($showHeader)
        <div class="title" data-aos="fade-up">
            <b>05</b>
            <p>Our products</p>
        </div>
        @endif
        <div class="zigzag__in mt-70">
            @foreach ($products as $product)
                @include('partials.zigzag_product_one')
            @endforeach
        </div>
    </div>
</section>
