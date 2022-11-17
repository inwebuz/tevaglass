@php
$phone = Helper::setting('contact.phone');
$email = Helper::setting('contact.email');
$siteTitle = Helper::setting('site.title');
@endphp
{{-- @if (auth()->check() &&
    auth()->user()->isAdmin())
<div class="py-3 px-3 text-light position-fixed"
    style="top: 0; left: 0; z-index: 10000;width: 220px;background-color: #000;">
    <div class="container-fluid">
        <a href="{{ url('admin') }}" class="text-light">Панель управления</a>
    </div>
</div>
@endif --}}

<!-- menu -->
<div class="menu">
    <div class="menu__box">
        <svg class="menu__close" xmlns="http://www.w3.org/2000/svg" width="24" height="24">
            <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
        </svg>
        <a href="{{ route('home') }}" class="menu__logo">
            <img src="{{ $logo }}" alt="{{ $siteTitle }}" />
            <span>{{ $siteTitle }}</span>
        </a>
        @foreach ($headerMenuItems as $item)
        <a href="{{ $item->url }}" class="menu__item">
            <span>{{ $item->name }}</span>
            <svg>
                <use xlink:href="#icon-arrow-right"></use>
            </svg>
        </a>
        @endforeach
    </div>
</div>

<!-- === header === -->
<header class="header">
    <div class="header__in">
        <a href="{{ route('home') }}" class="header__logo">
            <img src="{{ $logo }}" alt="{{ $siteTitle }}" />
            <span>{{ $siteTitle }}</span>
        </a>
        <div class="header__nav">
            @foreach ($headerMenuItems as $item)
                <div class="header__link @if($item->url == route('products.index')) header__link__has__submenu @else header__link__no__submenu @endif">
                    <a href="{{ $item->url }}">{{ $item->name }}</a>
                    @if ($item->url == route('products.index'))
                        <div class="header__link__submenu">
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ $category->url }}">{{ $category->getTranslatedAttribute('name') }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="header__btn">
            <svg x="0px" y="0px" viewBox="0 0 330 330" style="enable-background: new 0 0 330 330" xml:space="preserve">
                <g>
                    <path d="M315,0H15C6.716,0,0,6.716,0,15v300c0,8.284,6.716,15,15,15h300c8.284,0,15-6.716,15-15V15C330,6.716,323.284,0,315,0z M300,300H30V30h270V300z" />
                    <path d="M90.001,109.999h150c8.284,0,15-6.716,15-15s-6.716-15-15-15h-150c-8.284,0-15,6.716-15,15S81.717,109.999,90.001,109.999z" />
                    <path d="M90.001,179.999h150c8.284,0,15-6.716,15-15c0-8.284-6.716-15-15-15h-150c-8.284,0-15,6.716-15,15 C75.001,173.283,81.717,179.999,90.001,179.999z" />
                    <path d="M90.001,249.999h150c8.284,0,15-6.716,15-15c0-8.284-6.716-15-15-15h-150c-8.284,0-15,6.716-15,15 C75.001,243.283,81.717,249.999,90.001,249.999z" />
                </g>
            </svg>
        </div>
    </div>
</header>
