@extends('layouts.app')

@section('seo_title', __('main.wishlist'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    @if(!$wishlist->isEmpty())

        <section class="wishlist">
            <div class="container">
                <h1>{{ __('main.wishlist') }}</h1>
                <div class="content-top">
                    <strong>{{ __('main.products2') }}: <span class="wishlist_count">{{ $wishlist->getTotalQuantity() }}</span></strong>
                </div>

                {{-- <div class="catalog-content">
                    <div class="row products-wrap">
                        @foreach($wishlistItems as $wishlistItem)
                            @php
                                $product = $wishlistItem->associatedModel;
                            @endphp
                            <div class="col-xl-2 col-lg-3 col-12 product-card__parent mb-4">
                                @include('partials.product_one')
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                <div class="wishlist-items radius-14 wishlist_items_container">
                    @foreach($wishlistItems as $wishlistItem)
                        @php
                            $product = $wishlistItem->associatedModel;
                        @endphp
                        <div class="wishlist-box wishlist_item_line d-flex flex-column flex-lg-row flex-lg-nowrap align-items-lg-center border p-2 p-lg-4 radius-6 mb-3 text-center text-lg-left">
                            <div class="wishlist-box__delete d-none d-lg-block mr-lg-3">
                                <a href="javascript:;" data-remove-url="{{ route('wishlist.delete', $wishlistItem->id) }}" class="remove-from-wishlist-btn only-icon">
                                    <strong class="text-danger">&times;</strong>
                                </a>
                            </div>
                            <div class="wishlist-box__img mr-lg-3">
                                <a href="{{ $product->url }}">
                                    <img src="{{ $product->micro_img }}" alt="{{ $wishlistItem->name }}">
                                </a>
                            </div>
                            <div class="wishlist-box__about mr-lg-3">
                                <h4>
                                    <a href="{{ $product->url }}" class="text-dark">{{ $wishlistItem->name }}</a>
                                </h4>
                            </div>
                            <div class="wishlist-box__price-m ml-lg-auto">
                                <ul class="price-info__list">
                                    <li class="text-nowrap">
                                        <strong>{{ Helper::formatPrice($wishlistItem->price) }}</strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="wishlist-box__delete d-lg-none mt-2">
                                <a href="javascript:;" data-remove-url="{{ route('wishlist.delete', $wishlistItem->id) }}" class="remove-from-wishlist-btn only-icon">
                                    <strong class="text-danger">&times;</strong>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @else
        <section class="wishlist-empty">
            <div class="container">
                <div class="wishlist-empty__wrap">
                    {{-- <img src="{{ asset('images/wishlist/wishlist-empty.png') }}" alt="{{ __('main.wishlist_is_empty') }}"> --}}
                    <h1 class="text-center">{{ __('main.wishlist_is_empty') }}</h1>
                    {{-- <p class="text-center">
                        {!! __('main.wishlist_empty_description_1', ['url' => route('categories')]) !!}
                        @guest
                            {{ __('main.or') }}
                            {!! __('main.wishlist_empty_description_2', ['url' => route('login')]) !!}
                        @endguest
                    </p> --}}
                </div>
            </div>
        </section>

        <x-bestseller-products></x-bestseller-products>

    @endif
</main>

@endsection
