@extends('layouts.app')

@section('seo_title', __('main.order'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    @include('partials.alerts')

    <div class="container py-4 py-lg-5">

        {{-- @auth
            <div class="mb-5 d-none d-lg-block">
                <a href="{{ route('profile.orders') }}">
                    <strong> &larr; {{ __('main.back_to_orders') }}</strong>
                </a>
            </div>
        @endauth --}}

        <h1>{{ __('main.view_order') }}</h1>

        {{-- <div class="mb-4">
            @auth
                <a href="{{ route('profile.orders') }}" class="btn btn-primary">
                    <i class="fa fa-angle-left mr-2"></i>
                    {{ __('main.back_to_orders') }}
                </a>
            @endauth
            <a href="{{ route('order.print', ['order' => $order->id, 'check' => md5($order->created_at)]) }}" class="btn btn-link" target="_blank">
                <i class="text-dark fa fa-print mr-2"></i>
                <span class="text-dark">{{ __('main.print_version') }}</span>
            </a>
        </div> --}}

        <div class="box">
            <h3 class="box-header">
                {{ __('main.order') }} #{{ $order->id }}
            </h3>

            <p>
                {{ $order->payment_method_title }}
            </p>

            @include('partials.order_status')

            @if($order->isPending())
                <div class="mb-4">
                    @if($order->payment_method_id == \App\Models\Order::PAYMENT_METHOD_PAYME)
                        <form id="form-payme" method="POST" action="https://checkout.paycom.uz/">
                            <input type="hidden" name="merchant" value="{{ config('services.paycom.merchant_id') }}">
                            <input type="hidden" name="amount" value="{{ $order->total_tiyin }}">
                            <input type="hidden" name="account[order_id]" value="{{ $order->id }}">
                            <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                            <input type="hidden" name="currency" value="860">
                            <input type="hidden" name="callback" value="{{ $order->url }}">
                            <input type="hidden" name="callback_timeout" value="15">
                            <input type="hidden" name="description" value="{{ __('main.order') . ': ' . $order->id }}">
                            <input type="hidden" name="detail" value=""/>

                            <input type="hidden" name="button" data-type="svg" value="colored">
                            <div class="row">
                                <div class="col-sm-8 col-md-6 col-lg-4 img-container">
                                    <div id="button-container" class="button-container payme-button-container"></div>
                                </div>
                            </div>
                            <button type="submit" class="button d-none">{{ __('main.pay_with', ['operator' => 'Payme']) }}</button>
                        </form>
                        <script src="https://cdn.paycom.uz/integration/js/checkout.min.js"></script>
                        <script>
                            Paycom.Button('#form-payme', '#button-container')
                        </script>
                    @elseif($order->payment_method_id == \App\Models\Order::PAYMENT_METHOD_CLICK)
                        <form id="click_form" action="https://my.click.uz/services/pay" method="get">
                            <input type="hidden" name="amount" value="{{ $order->total }}" />
                            <input type="hidden" name="merchant_id" value="{{ config('services.click.merchant_id') }}"/>
                            <input type="hidden" name="merchant_user_id" value="{{ config('services.click.user_id') }}"/>
                            <input type="hidden" name="service_id" value="{{ config('services.click.service_id') }}"/>
                            <input type="hidden" name="transaction_param" value="{{ $order->id }}"/>
                            <input type="hidden" name="return_url" value="{{ $order->url }}"/>
                            {{--<input type="hidden" name="card_type" value="uzcard/humo"/>--}}
                            <button type="submit" class="click_logo"><i></i>{{ __('main.pay_with', ['operator' => 'CLICK']) }}</button>
                        </form>
                    @endif
                </div>
            @endif


            @if($order->payment_method_id == \App\Models\Order::PAYMENT_METHOD_ZOODPAY_INSTALLMENTS)
                <div class="my-4">
                    @if ($zoodpayTransaction && !empty($zoodpayTransaction->zoodpay_status))
                        <p>
                            Zoodpay Status:
                            {{ $zoodpayTransaction->zoodpay_status }}.
                            @if (!empty($zoodpayTransaction->zoodpay_error_message))
                                {{ $zoodpayTransaction->zoodpay_error_message }}
                            @endif
                        </p>
                    @endif
                    @if (empty($zoodpayTransaction->zoodpay_status) || $zoodpayTransaction->zoodpay_status == 'In active')
                        <form id="zoodpay_form" action="{{ route('zoodpay.transaction.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="zoodpay-button-container">
                                {{-- <button type="submit" class="btn btn-lg btn-info">{{ __('main.pay_with', ['operator' => 'ZOODPAY']) }}</button> --}}
                                <div>{{ __('main.pay_with', ['operator' => 'ZOODPAY']) }}:</div>
                                <input type="image" src="{{ asset('images/payment/zoodpay/button-' . app()->getLocale() . '.jpg') }}" alt="{{ __('main.pay_with', ['operator' => 'ZOODPAY']) }}">
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <div class="order_table table-responsive">
                <table class="table products-list-table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th class="border-bottom-0">{{ __('main.product') }}</th>
                            <th class="border-bottom-0">{{ __('main.price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $orderItem)
                            <tr>
                                <td>
                                    {{ $orderItem->name }}
                                    <strong> × {{ $orderItem->quantity }}</strong>
                                </td>
                                <td class="text-nowrap"> {{ Helper::formatPrice($orderItem->total) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="order_total">
                            <td><strong>{{ __('main.delivery') }}</strong></td>
                            <td class="text-nowrap"><strong>{{ Helper::formatPrice($order->shipping_price) }}</strong></td>
                        </tr>
                        <tr class="order_total">
                            <td><h4 class="m-0">{{ __('main.total') }}</h4></td>
                            <td class="text-nowrap"><h4 class="m-0">{{ Helper::formatPrice($order->total) }}</h4></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="pb-5"></div>

    </div>

</main>


@endsection

@section('styles')
    <style>
        .click_logo {
            padding:15px 35px 15px 20px;
            cursor:pointer;
            color: #fff;
            line-height:60px;
            font-size: 24px;
            white-space: nowrap;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: center;
            border: 1px solid #343643;
            border-radius: 10px;
            background-color: #343643;
        }
        .click_logo i {
            background: url(/images/partners/click.png) no-repeat top left;
            background-size: contain;
            width:60px;
            height: 60px;
            display: block;
            float: left;
        }
        .payme-button-container input[type="image"] {
            /* max-width: 200px; */
            max-width: 100%;
        }
        .zoodpay-button-container input[type="image"] {
            /* max-width: 280px; */
            max-width: 100%;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(function(){
            // @if($order->isPending())
            //     @if($order->payment_method_id == \App\Models\Order::PAYMENT_METHOD_CLICK)
            //         $('#click_form').trigger('submit');
            //     @endif
            // @endif
        });
    </script>
@endsection
