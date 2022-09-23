@extends('layouts.app')

@section('seo_title', __('main.cart'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    @if(!$cart->isEmpty())

        <section class="cart">
            <div class="container">
                <h1>{{ __('main.cart') }}</h1>
                <div class="row">
                    <div class="col-xl-8 col-lg-9">
                        <div class="cart-items cart_items_container">
                            @foreach($cartItems as $cartItem)
                                @php
                                    $product = $cartItem->associatedModel;
                                @endphp
                                <div class="cart-box cart_item_line d-flex flex-column flex-lg-row flex-lg-nowrap align-items-lg-center border py-3 px-2 p-lg-4 radius-6 mb-3 text-center text-lg-left">
                                    <div class="cart-box__delete d-none d-lg-block mr-lg-3">
                                        <a href="{{ route('cart.delete', $cartItem->id) }}" class="remove-from-cart-btn" data-toggle="cart-box-delete">
                                            <strong class="text-danger">&times;</strong>
                                        </a>
                                    </div>
                                    <div class="cart-box__img mr-lg-3 mb-1 mb-lg-0">
                                        <a href="{{ $product->url }}">
                                            <img src="{{ $product->micro_img }}" alt="{{ $cartItem->name }}">
                                        </a>
                                    </div>
                                    <div class="cart-box__about mr-lg-3 mb-1 mb-lg-0">
                                        <h4>
                                            <a href="{{ $product->url }}" class="text-dark">{{ $cartItem->name }}</a>
                                        </h4>
                                    </div>
                                    <div class="cart-box__amount ml-lg-auto mr-lg-3 mb-3 mb-lg-0">
                                        <div class="counter justify-content-center">
                                            <button type="button" class="radius-6" data-toggle="decrement"></button>
                                            <input type="text" class="update-cart-quantity-input" value="{{ $cartItem->quantity }}" name="cart-quantity-{{ $cartItem->id }}" data-id="{{ $cartItem->id }}" min="1" max="{{ $cartItem->availableQuantity }}" maxlength="3">
                                            <button type="button" class="radius-6" data-toggle="increment"></button>
                                        </div>
                                    </div>
                                    <div class="cart-box__price-d text-nowrap">
                                        <strong class="product_total">{{ Helper::formatPrice($cartItem->getPriceSumWithConditions()) }}</strong>
                                    </div>
                                    <div class="cart-box__delete d-lg-none mt-2">
                                        <a href="{{ route('cart.delete', $cartItem->id) }}" class="remove-from-cart-btn" data-toggle="cart-box-delete">
                                            <strong class="text-danger">&times;</strong>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if ($address)
                        <div class="delivery-info radius-14 d-none d-lg-block">
                            <h3>{{ __('main.delivery') }}</h3>
                            <p>{{ __('main.delivery_address') }}: <span class="active_delivery_address">{{ $address->address_line_1 }}</span></p>
                            <a href="#edit-address-modal" data-toggle="modal">{{ __('main.to_edit2') }}</a>
                        </div>
                        @endif


                        <div class="total-info text-center text-lg-left">
                            <div class="mb-4">
                                <h3>{{ __('main.total') }}: <span class="cart_total_price">{{ Helper::formatPrice($cart->getTotal()) }}</span></h3>
                            </div>
                            {{-- <ul class="total-info__list">
                                <li>
                                    <span>{{ __('main.products') }}</span>
                                    <span class="cart_standard_price_total">{{ Helper::formatPrice($standardPriceTotal) }}</span>
                                </li>
                                <li class="cart_discount_price_container @if($discount == 0) d-none @endif">
                                    <span>{{ __('main.discount') }}</span>
                                    <span class="text-danger">-<span class="cart_discount_price text-danger">{{ Helper::formatPrice($discount) }}</span></span>
                                </li>
                            </ul> --}}
                            <div>
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary lg radius-8">{{ __('main.proceed_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="cart-empty">
            <div class="container">
                <div class="cart-empty__wrap">
                    {{-- <img src="{{ asset('img/cart/cart-empty.png') }}" alt="{{ __('main.cart_is_empty') }}"> --}}
                    <h1 class="text-center">{{ __('main.cart_is_empty') }}</h1>
                    {{-- <p class="text-center">
                        {!! __('main.cart_empty_description_1', ['url' => route('categories')]) !!}
                        @guest
                            {{ __('main.or') }}
                            {!! __('main.cart_empty_description_2', ['url' => route('login')]) !!}
                        @endguest
                    </p> --}}
                </div>
            </div>
        </section>

        <x-bestseller-products></x-bestseller-products>

    @endif
</main>

@endsection


@section('after_footer_blocks')
<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mb-4">
                    {{ __('main.choose_address') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </h5>

                <div class="my-4">
                    @foreach ($addresses as $value)
                        <div class="custom-control custom-radio">
                            <input type="radio" id="address-line-{{ $value->id }}" value="{{ $value->id }}" name="address-line" class="custom-control-input" @if($address && $address->id == $value->id) checked @endif>
                            <label class="custom-control-label" for="address-line-{{ $value->id }}">{{ $value->address_line_1 }}</label>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="my-4">
                    <h5>{{ __('main.add_address') }}</h5>
                    <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-primary">{{ __('main.add') }}</a>
                </div>



            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('[name="address-line"]').on('change', function(){
                let addressID = $(this).val();
                let url = '{{ route('addresses.status.update', ['address' => 'address_id_placeholder', 'status' => 1]) }}';
                url = url.replace('address_id_placeholder', addressID);
                console.log(url);
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.address_line_1) {
                            $('.active_delivery_address').text(data.address_line_1);
                            $('#edit-address-modal').modal('hide');
                        }
                    });
            });
        });
    </script>
@endsection
