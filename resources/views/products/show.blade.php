@extends('layouts.app')

@section('seo_title', $product->getTranslatedAttribute('seo_title') ?: $product->getTranslatedAttribute('name'))
@section('meta_description', $product->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $product->getTranslatedAttribute('meta_keywords'))

@section('content')

    @include('partials.page_top', ['title' => $product->getTranslatedAttribute('name'), 'bg' => $product->bg])

    <section class="section">
        <div class="container">
            <div class="info__container">
                <div class="info">
                    <div class="info__half">
                        <div class="info__photo">
                            <img src="{{ $product->img }}" alt="{{ $product->getTranslatedAttribute('name') }}" />
                        </div>
                    </div>
                    <div class="info__content">
                        <h2 class="info__title">more about product</h2>
                        <p class="info__text">{{ $product->getTranslatedAttribute('description') }}</p>
                        <button class="btn btn--filled btn--md btn--order" type="button">
                            enquire now
                        </button>
                    </div>
                </div>

                <div class="static">
                    {!! $product->getTranslatedAttribute('body') !!}
                </div>

                {{-- <div class="info">
                <div class="info__half">
                    <div class="info__photo">
                        <img src="./assets/img/product-4.jpg" alt="" />
                    </div>
                </div>
                <div class="info__content">
                    <p class="info__text">
                        Window systems SOFTLINE from VEKA are designed for highly insulating
                        PVC-U windows. With VEKA class A profiles according to DIN EN 12608,
                        the SOFTLINE systems platform combines sophisticated multi-chamber
                        profile technology with extra-strong walls - for optimum thermal
                        insulation, durability, stability, and security. The SOFTLINE 82,
                        SOFTLINE 76 and SOFTLINE 70 window systems in installation depths of
                        82, 76, and 70 mm form a fully compatible window system platform
                        that also includes high-quality SOFTLINE front door systems. The
                        SOFTLINE window system combines elegant sightlines, even for large
                        elements, with optimum economy. Thanks to the high inherent
                        stability of the system and its highly insulating properties, modern
                        architecture with generous glass surfaces can be realised in
                        combination with outstanding energy efficiency.
                    </p>
                </div>
            </div> --}}

                {{-- <div class="info-materials">
                <h2 class="info__title">Materials and Finishes</h2>
                <ul class="info__list">
                    <li>Extruded rigid PVC with white smooth, homogeneous surface</li>
                    <li>Film lamination in wood or plain colours possible</li>
                    <li>Finished optionally on one or both sides</li>
                    <li>
                        Surface structure smooth or grained (colours according to VEKA
                        colour chart)
                    </li>
                    <li>Aluminum covers</li>
                    <li>
                        Sealing system with two sealing levels (outer and inner rebate seal)
                        made of high-quality material
                    </li>
                    <li>Circumferential in frame and sash</li>
                    <li>Seal colours: grey, black or caramel</li>
                    <li>
                        Glazing options: Single glazing, double or triple glazing, safety
                        glazing, soundproof glazing, special glazing
                    </li>
                    <li>Pane thickness: from 4 to 42 mm</li>
                </ul>
            </div>
        </div> --}}

                <div class="others">
                    <h2 class="others__title">Other products</h2>
                    @foreach ($otherProducts as $otherProduct)
                        <div class="others__box">
                            <a href="{{ $otherProduct->url }}" class="other">
                                <div class="other__photo">
                                    <img src="{{ $otherProduct->small_img }}" alt="" />
                                </div>
                                <h3 class="other__name">{{ $otherProduct->getTranslatedAttribute('name') }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
    </section>

@endsection

@section('after_footer_blocks')

@endsection

@section('scripts')

@endsection

@section('styles')

@endsection
