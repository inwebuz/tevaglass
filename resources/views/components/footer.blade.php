@php
$phone = Helper::setting('contact.phone');
$email = Helper::setting('contact.email');
$siteTitle = Helper::setting('site.title');
@endphp

<!-- === footer === -->
<section class="footer">
    <div class="container">
        <div class="footer__in">
            <div class="footer__col">
                <h3 class="footer__heading">About us</h3>
                <p class="footer__text">
                    {{ $footerDescription }}
                </p>
            </div>
            <div class="footer__col">
                <h3 class="footer__heading">Useful links</h3>
                <ul class="footer__links">
                    @foreach ($footerMenuItems as $item)
                    <li>
                        <a href="{{ $item->url }}">
                            <svg class="footer__arrow">
                                <use xlink:href="#link-arrow"></use>
                            </svg>
                            <span>{{ $item->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__col">
                <h3 class="footer__heading">Products</h3>
                <ul class="footer__links">
                    @foreach ($categories as $category)
                    <li>
                        <a href="{{ $category->url }}">
                            <svg class="footer__arrow">
                                <use xlink:href="#link-arrow"></use>
                            </svg>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__col">
                <h3 class="footer__heading">Contacts</h3>
                <ul class="footer__links">
                    <li>
                        <a href="tel:{{ Helper::phone($phone) }}">
                            <svg class="footer__icon footer__icon--phone">
                                <use xlink:href="#icon-phone"></use>
                            </svg>
                            <span>{{ $phone }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contacts') }}">
                            <svg class="footer__icon footer__icon--address">
                                <use xlink:href="#icon-address"></use>
                            </svg>
                            <span>{{ $address }}</span
                            >
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__copy">
            <p>{{ date('Y') }} &copy; {{ $siteTitle }}. {{ __('main.all_rights_reserved') }}</p>
        </div>
    </div>
</section>

{{-- <a href="{{ route('compare.index') }}" class="compare-page-link btn btn-primary xs radius-6">{{ __('main.compare_list') }}</a> --}}

{{-- <div class="accept-cookie">
    <div class="rounded bg-light text-dark border py-2 px-3 ">
        {{ __('main.site_uses_cookie') }}
        <a href="#" class="accept-cookie-btn">{{ __('main.to_accept2') }}</a>
    </div>
</div> --}}

{{-- <!-- Contact Modal -->
<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('contacts.send') }}" class="contact-form">
                @csrf
                <input type="hidden" name="product_id" value="">
                <div class="modal-body">
                    <h5 class="modal-title">
                        {{ __('main.form.send_request') }}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </h5>
                    <br>
                    <div class="form-result"></div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name"
                            placeholder="{{ __('main.form.your_name') }}" required />
                    </div>
                    <div class="form-group">
                        <input class="form-control phone-input-mask" type="text" name="phone"
                            placeholder="{{ __('main.form.phone') }}" required />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="4"
                            placeholder="{{ __('main.form.message') }}"></textarea>
                    </div>

                    <div class="row gutters-5 mb-4">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <input type="text" name="captcha" class="form-control"
                                placeholder="{{ __('main.form.security_code') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <div class="captcha-container">
                                <img src="{{ asset('images/captcha.png') }}" alt="Captcha" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary radius-6" type="submit">
                            {{ __('main.form.send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Phone Call Modal -->
<div class="modal fade" id="phone-call-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('contacts.send') }}" class="contact-form">
                @csrf
                <input type="hidden" name="type" value="{{ \App\Models\Contact::TYPE_CALLBACK }}">

                <div class="modal-body">
                    <h5 class="modal-title" id="phone-call-modal-label">
                        {{ __('main.callback') }}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </h5>
                    <br>
                    <div class="form-result"></div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name"
                            placeholder="{{ __('main.form.your_name') }}" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control phone-input-mask" type="text" name="phone"
                            placeholder="{{ __('main.form.phone') }}" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="message"
                            placeholder="{{ __('main.what_time_should_we_call_you_back') }}" required>
                    </div>

                    <div class="row gutters-5 mb-4">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <input type="text" name="captcha" class="form-control"
                                placeholder="{{ __('main.form.security_code') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <div class="captcha-container">
                                <img src="{{ asset('images/captcha.png') }}" alt="Captcha" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary radius-6" type="submit">
                            {{ __('main.form.send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="cart-message mb-3 mt-2 text-center h4">
                    {{ __('main.product_added_to_cart') }}
                </h4>
                <div class="d-flex flex-nowrap justify-content-center">
                    <button type="button" class="btn secondary radius-6 mx-1 mb-2" data-dismiss="modal">
                        {{ __('main.continue_shopping') }}
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-primary radius-6 mb-2">
                        {{ __('main.go_to_cart') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <!-- Regions list Modal -->
<div class="modal fade" id="regions-list-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="mb-3 mt-2 text-center h4">
                    {{ __('main.choose_a_region') }}
                </h4>
                <div class="text-center">
                    <form action="{{ route('region.set') }}" method="post" class="regions-list-form">

                        @csrf

                        <div class="form-result"></div>

                        <div class="list-group regions-list-group">
                            @foreach ($regions as $region)
                            <span class="list-group-item @if ($region->id ==
                                    $currentRegionID) active disabled @endif" data-region-id="{{ $region->id }}">{{
                                $region->getTranslatedAttribute('short_name') }}</span>
                            @endforeach
                        </div>
                        <input type="hidden" name="region_id" value="">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
