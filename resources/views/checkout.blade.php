@extends('layouts.app')

@section('seo_title', __('main.checkout'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

    <main class="main">

        <section class="content-header">
            <div class="container">
                @include('partials.breadcrumbs')
            </div>
        </section>

        <section class="checkout">
            <div class="container">

                <h1>{{ __('main.checkout') }}</h1>

                @if (!$cart->isEmpty())
                    <div class="row">
                        <div class="col-xl-8 col-lg-9">
                            <form action="{{ route('order.add') }}" method="post" id="checkout-form" class="checkout-form">

                                @csrf

                                <div class="checkout-form__content mb-4">
                                    <h4 class="mb-2">{{ __('main.your_order') }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('main.product') }}</th>
                                                    <th class="w-1 text-right">{{ __('main.price') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cartItems as $cartItem)
                                                    <tr>
                                                        <td>
                                                            <a class="black-link" href="{{ $cartItem->associatedModel->url }}"
                                                                target="_blank">{{ $cartItem->name }}</a>
                                                            <strong> × {{ $cartItem->quantity }}</strong>
                                                            @if ($cartItem->quantity > $cartItem->availableQuantity)
                                                                <br>
                                                                <strong class="text-danger">{{ __('main.available') }}: {{ $cartItem->availableQuantity }}</strong>
                                                            @endif
                                                        </td>
                                                        <td class="text-nowrap text-right"> {{ Helper::formatPrice($cartItem->getPriceSumWithConditions()) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        <strong>{{ __('main.delivery') }}</strong>
                                                    </td>
                                                    <td class="text-nowrap text-right">
                                                        <strong>{{ Helper::formatPrice($shippingMethod->price) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="m-0">{{ __('main.total') }}</h4>
                                                    </td>
                                                    <td class="text-nowrap text-right">
                                                        <h4 class="m-0">{{ Helper::formatPrice($cart->getTotal() + $shippingMethod->price) }}</h4>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="checkout-form__content mb-4">
                                    <h4 class="mb-2">{{ __('main.contact_information') }}</h4>
                                    <div>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('main.form.your_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror"
                                                value="{{ old('name', optional(auth()->user())->name) }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                <span>{{ __('main.form.phone_number') }}</span>
                                                <span class="text-danger">*</span>
                                                {{-- <small class="text-muted">({{ __('main.phone_number_example') }})</small> --}}
                                            </label>

                                            <input type="tel" name="phone_number"
                                                class="phone-input-mask form-control  @error('phone_number') is-invalid @enderror"
                                                value="{{ old('phone_number', optional(auth()->user())->phone_number) ?? '' }}"
                                                required pattern="^\+998\d{2}\s\d{3}-\d{2}-\d{2}$">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                    <label class="control-label">
                                        <span>{{ __('main.form.email') }} <span class="text-danger">*</span></span>
                                    </label>

                                    <input type="email" name="email"
                                        class="form-control  @error('email') is-invalid @enderror"
                                        value="{{ old('email', optional(auth()->user())->email) ?? '' }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> --}}

                                        <div class="form-group">
                                            <label class="control-label">{{ __('main.address') }}</label>
                                            <input type="text" name="address_line_1"
                                                class="form-control  @error('address_line_1') is-invalid @enderror"
                                                value="{{ old('address_line_1', optional($address)->address_line_1) ?? '' }}">
                                            @error('address_line_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                    <input type="hidden" name="latitude" value="">
                                    <input type="hidden" name="longitude" value="">
                                    <input type="hidden" name="location_accuracy" value="">
                                    <label class="control-label">{{ __('main.location') }}</label>
                                    <div id="location-text"></div>
                                    <div>
                                        <button type="button" class="btn btn-primary get-location-btn">{{ __('main.determine_geolocation') }}</button>
                                    </div>
                                </div> --}}

                                        <div class="form-group">
                                            <label class="control-label d-block">{{ __('main.communication_method') }}</label>
                                            @php
                                                $checkedCommunicationMethodKey = old('communication_method') ?: 0;
                                            @endphp
                                            @foreach ($communicationMethods as $communicationMethodKey => $communicationMethod)
                                                <div class="form-check d-inline-block mr-2">
                                                    <input class="form-check-input"
                                                        id="communication_method_{{ $communicationMethodKey }}" type="radio"
                                                        name="communication_method" value="{{ $communicationMethodKey }}"
                                                        @if ($checkedCommunicationMethodKey == $communicationMethodKey) checked @endif
                                                        required>
                                                    <label class="form-check-label"
                                                        for="communication_method_{{ $communicationMethodKey }}">
                                                        {{ $communicationMethod }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('communication_method')
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ __('main.choose_value') }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label d-block">{{ __('main.payment_method') }}</label>
                                            @php
                                                $checkedPaymentMethodId = old('payment_method_id'); // default = 1 - cash
                                                if (!$checkedPaymentMethodId && !$paymentMethods->isEmpty()) {
                                                    $checkedPaymentMethodId = $paymentMethods->first()->id;
                                                }
                                            @endphp
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <div class="form-check d-inline-block mr-2">
                                                    <input class="form-check-input"
                                                        id="payment_method_{{ $paymentMethod->id }}" type="radio"
                                                        name="payment_method_id" value="{{ $paymentMethod->id }}"
                                                        @if ($checkedPaymentMethodId == $paymentMethod->id) checked @endif
                                                        required>
                                                    <label class="form-check-label"
                                                        for="payment_method_{{ $paymentMethod->id }}">
                                                        {{ $paymentMethod->getTranslatedAttribute('name') }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('payment_method_id')
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ __('main.choose_value') }}</strong>
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                            @php
                                            $checkedShippingMethodID = old('shipping_method_id') ?: 1; // default = 1 - Standard
                                            @endphp
                                            @foreach ($shippingMethods as $shippingMethod)
                                            <label class="radio-label">
                                                <input id="shipping_method_{{ $shippingMethod->id }}" type="radio"
                                                    name="shipping_method_id" value="{{ $shippingMethod->id }}"
                                                    @if ($checkedShippingMethodID == $shippingMethod->id) checked @endif required>
                                                <strong>{{ $shippingMethod->name }}</strong>
                                            </label>
                                            @endforeach
                                            @error('shipping_method_id')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ __('main.choose_value') }}</strong>
                                            </div>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group">
                                            <label class="control-label">{{ __('main.form.message') }}</label>
                                            <input type="text" name="message"
                                                class="form-control  @error('message') is-invalid @enderror"
                                                value="{{ old('message') }}">
                                            @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group d-none">
                                            <label class="control-label">{{ __('main.order_type') }} <span
                                                    class="text-danger">*</span></label></label>
                                            @php
                                            $checkedOrderTypeKey = old('type') ?: 0;
                                            @endphp
                                            @foreach ($orderTypes as $orderTypeKey => $orderType)
                                            <div class="form-check">
                                                <input class="form-check-input" id="order_type_{{ $orderTypeKey }}" type="radio"
                                                    name="type" value="{{ $orderTypeKey }}" @if ($checkedOrderTypeKey == $orderTypeKey)
                                                    checked @endif>
                                                <label class="form-check-label" for="order_type_{{ $orderTypeKey }}">
                                                    {{ $orderType }}
                                                </label>
                                            </div>
                                            @endforeach
                                            @error('type')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ __('main.choose_value') }}</strong>
                                            </div>
                                            @enderror
                                        </div> --}}

                                        {{-- <div class="form-group d-none">

                                            <label for="create_an_account_checkbox" data-toggle="collapse"
                                                data-target="#create_an_account_block" aria-controls="create_an_account_block">
                                                <input id="create_an_account_checkbox" type="checkbox" name="create_an_account" />
                                                Create an account?
                                            </label>

                                            <div id="create_an_account_block" class="collapse one">
                                                <div class="card-body1">
                                                    <label> Account password <span>*</span></label>
                                                    <input name="password" type="password" class="form-control">
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="form-group">
                                            <input id="public_offer" name="public_offer" type="checkbox" required>
                                            <label for="public_offer">
                                                {!! __('main.accept_the_terms', ['url' => '<a href="' . $publicOfferPage->url . '"
                                                    target="_blank" class="text-primary">' . __('main.of_public_offer') . '</a>'])
                                                !!}
                                                {{ __('main.i_confirm_order') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            @error('public_offer')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div> --}}

                                    </div>
                                </div>

                                <div class="checkout-form__content mb-4 @if (!$isGift) d-none @endif">
                                    <h4 class="mb-2">{{ __('main.receipent_information') }}</h4>
                                    <div>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('main.form.name') }}</label>
                                            <input type="text" name="shipping_name" class="form-control  @error('shipping_name') is-invalid @enderror"
                                                value="{{ old('shipping_name') }}">
                                            @error('shipping_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                <span>{{ __('main.form.phone_number') }}</span>
                                            </label>

                                            <input type="tel" name="shipping_phone_number"
                                                class="phone-input-mask form-control  @error('shipping_phone_number') is-invalid @enderror"
                                                value="{{ old('shipping_phone_number') ?? '' }}">
                                            @error('shipping_phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                    <label class="control-label">
                                        <span>{{ __('main.form.email') }}</span>
                                    </label>

                                    <input type="email" name="shipping_email"
                                        class="form-control  @error('shipping_email') is-invalid @enderror"
                                        value="{{ old('shipping_email') ?? '' }}" required>
                                    @error('shipping_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> --}}

                                        <div class="form-group">
                                            <label class="control-label">{{ __('main.address') }}</label>
                                            <input type="text" name="shipping_address"
                                                class="form-control  @error('shipping_address') is-invalid @enderror"
                                                value="{{ old('shipping_address') ?? '' }}">
                                            @error('shipping_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="checkout-form__content">
                                    @if (!$checkoutAvailable)
                                        <div class="text-danger my-2">{{ __('main.checkout_not_available') }} <a
                                                href="{{ route('cart.index') }}">{{ __('main.go_to_cart') }}</a></div>
                                    @endif
                                    <div>
                                        <button type="submit" class="btn btn-primary lg radius-8 @if (!$checkoutAvailable) disabled @endif"
                                            @if (!$checkoutAvailable) disabled @endif>{{ __('main.place_order') }}</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                @else
                    <div class="my-5 lead text-center">{{ __('main.cart_is_empty') }}</div>
                @endif

            </div>
        </section>

    </main>

@endsection

@section('after_footer_blocks')

    {{-- @php
$terms = Helper::staticText('zoodpay_payment_terms_and_conditions');
@endphp
<!-- zoodpay_terms Modal -->
<div class="modal fade" id="zoodpay-terms-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! $terms->description !!}
            </div>
        </div>
    </div>
</div>
@endsection --}}

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let form = $('.checkout-form');
            let locationText = $('#location-text');
            $('.get-location-btn').on('click', function(e) {
                e.preventDefault();

                getLocation();

                function getLocation() {
                    locationText.html(spinnerHTML()).addClass('mb-2');
                    if (navigator.geolocation) {
                        let getOptions = {
                            maximumAge: 10000,
                            timeout: 5000,
                            enableHighAccuracy: true
                        };
                        navigator.geolocation.getCurrentPosition(geoSuccess, geoError, getOptions);
                    } else {
                        locationText.text("{{ __('main.geolocation_is_not_supported_by_browser') }}");
                    }
                }

                function geoError(error) {
                    // console.log(error);
                    locationText.text("{{ __('main.failed_to_determine_geolocation') }}");
                }

                function geoSuccess(position) {
                    // console.log(position);
                    locationText.text("{{ __('main.latitude') }}: " + position.coords.latitude + "; {{ __('main.longitude') }}: " + position.coords.longitude);
                    form.find('[name="latitude"]').val(position.coords.latitude);
                    form.find('[name="longitude"]').val(position.coords.longitude);
                    form.find('[name="location_accuracy"]').val(position.coords.accuracy);
                }
            });

        });
    </script>
@endsection
