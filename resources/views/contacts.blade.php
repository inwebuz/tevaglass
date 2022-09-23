@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@php
    $phone = Helper::setting('contact.phone');
    $email = Helper::setting('contact.email');
    $map = Helper::setting('contact.map');
@endphp

@section('content')

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name'), 'bg' => $page->bg])

<section class="section">
    <div class="container">
        <div class="contact__map">
            {!! $map !!}
        </div>
        <div class="contact__cards">
            <div class="contact__card" data-aos="fade-up" data-aos-delay="0">
                <span class="contact__icon">
                    <svg>
                        <use xlink:href="#icon-home"></use>
                    </svg>
                </span>
                <h3>Adress</h3>
                <p>{{ $address }}</p>
            </div>
            <div class="contact__card" data-aos="fade-up" data-aos-delay="100">
                <span class="contact__icon">
                    <svg>
                        <use xlink:href="#icon-email"></use>
                    </svg>
                </span>
                <h3>E-mail</h3>
                <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
            </div>
            <div class="contact__card" data-aos="fade-up" data-aos-delay="200">
                <span class="contact__icon">
                    <svg>
                        <use xlink:href="#icon-home-phone"></use>
                    </svg>
                </span>
                <h3>Phone</h3>
                <p><a href="tel:{{ Helper::phone($phone) }}">{{ $phone }}</a></p>
            </div>
        </div>
        <div class="contact__form">
            <h2 class="contact__form-title">Contact us</h2>
            <form class="form contact-form" action="{{ route('contacts.send') }}" method="POST">
                @csrf
                <div class="input__box col-3">
                    <input
                        type="text"
                        class="input input--grey"
                        placeholder="Name"
                        name="name"
                    />
                    <svg class="input__icon">
                        <use xlink:href="#icon-person-orange"></use>
                    </svg>
                </div>
                <div class="input__box col-3">
                    <input
                        type="text"
                        class="input input--grey"
                        placeholder="Phone"
                        name="phone"
                    />
                    <svg class="input__icon">
                        <use xlink:href="#icon-phone-orange"></use>
                    </svg>
                </div>
                <div class="input__box col-3">
                    <input
                        type="email"
                        class="input input--grey"
                        placeholder="Mail"
                        name="email"
                    />
                    <svg class="input__icon">
                        <use xlink:href="#icon-email-orange"></use>
                    </svg>
                </div>
                <div class="input__box col-1">
                    <textarea
                        cols="30"
                        rows="10"
                        class="input input--grey input--textarea"
                        placeholder="Your comments"
                        name="message"
                    ></textarea>
                    <svg class="input__icon">
                        <use xlink:href="#icon-quote-orange"></use>
                    </svg>
                </div>
                <div class="input__box col-1">
                    <button class="btn btn--outlined btn--md" type="submit">Send message</button>
                </div>
                <div class="input__box col-1">
                    <div class="form-result"></div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
