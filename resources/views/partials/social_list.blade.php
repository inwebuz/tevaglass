
@php
    $telegram = setting('contact.telegram');
    $facebook = setting('contact.facebook');
    $instagram = setting('contact.instagram');
@endphp
@if ($telegram)
    {{-- <li><a class="social-btn telegram" href="{{ setting('contact.telegram') }}" title="Telegram" target="_blank" rel="nofollow"><i class="ion-paper-airplane fab fa-telegram-plane"></i></a></li> --}}
    <li>
        <a href="{{ $telegram }}" title="Telegram" target="_blank" rel="nofollow">
            <svg width="18" height="18" fill="#fff">
                <use xlink:href="#telegram"></use>
            </svg>
        </a>
    </li>
@endif
@if ($facebook)
    {{-- <li><a class="social-btn facebook" href="{{ setting('contact.facebook') }}" title="Facebook" target="_blank" rel="nofollow"><i class="ion-social-facebook fab fa-facebook-f"></i></a></li> --}}
    <li>
        <a href="{{ $facebook }}" title="Facebook" target="_blank" rel="nofollow">
            <svg width="18" height="18" fill="#fff">
                <use xlink:href="#facebook"></use>
            </svg>
        </a>
    </li>
@endif
@if ($instagram)
    {{-- <li><a class="social-btn instagram" href="{{ setting('contact.instagram') }}" title="Instagram" target="_blank" rel="nofollow"><i class="ion-social-instagram-outline fab fa-instagram"></i></a></li> --}}
    <li>
        <a href="{{ $instagram }}" title="Instagram" target="_blank" rel="nofollow">
            <svg width="18" height="18" fill="#fff">
                <use xlink:href="#instagram"></use>
            </svg>
        </a>
    </li>
@endif

