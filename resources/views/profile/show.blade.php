@extends('layouts.app')
@section('seo_title', __('main.profile'))

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container py-4 py-lg-5">

        @include('partials.alerts')

        <h1>{{ __('main.profile') }}</h1>

        <div class="row">
            <div class="col-6 mb-4">
                <a href="{{ route('profile.edit') }}" class="text-dark d-flex border p-3 radius-8 flex-row flex-nowrap align-items-center">
                    <svg width="30" height="30" fill="#FCB300">
                        <use xlink:href="#user"></use>
                    </svg>
                    <span class="ml-2">{{ __('main.edit') }}</span>
                </a>
            </div>
            <div class="col-6 mb-4">
                <a href="{{ route('profile.orders') }}" class="text-dark d-flex border p-3 radius-8 flex-row flex-nowrap align-items-center">
                    <svg width="30" height="30" fill="#FCB300">
                        <use xlink:href="#cube"></use>
                    </svg>
                    <span class="ml-2">{{ __('main.orders2') }}:</span>
                    <span class="ml-2 wishlist_count">{{ $ordersQuantity }}</span>
                </a>
            </div>
            <div class="col-6 mb-4">
                <a href="{{ route('cart.index') }}" class="text-dark d-flex border p-3 radius-8 flex-row flex-nowrap align-items-center">
                    <svg width="30" height="30" fill="#FCB300">
                        <use xlink:href="#cart"></use>
                    </svg>
                    <span class="ml-2">{{ __('main.cart') }}:</span>
                    <span class="ml-2 cart_count">{{ $cartQuantity }}</span>
                </a>
            </div>
            <div class="col-6 mb-4">
                <a href="{{ route('wishlist.index') }}" class="text-dark d-flex border p-3 radius-8 flex-row flex-nowrap align-items-center">
                    <svg width="30" height="30" fill="#FCB300">
                        <use xlink:href="#heart"></use>
                    </svg>
                    <span class="ml-2">{{ __('main.wishlist') }}:</span>
                    <span class="ml-2 wishlist_count">{{ $wishlistQuantity }}</span>
                </a>
            </div>
        </div>

        <div class="my-4">
            <form class="logout-form" action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-danger radius-6" type="submit">{{ __('main.nav.logout') }}</button>
            </form>
        </div>

    </div>

    {{-- @include('partials.sidebar_profile') --}}

</main>

@endsection
