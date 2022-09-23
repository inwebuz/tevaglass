@php
if (!isset($size)) {
$size = 'small';
}
$showImg = $size . '_img';
$showSecondImg = 'second_' . $size . '_img';
$discounted = $product->isDiscounted();
@endphp

<div class="product-item radius-13">

    <a href="{{ $product->url }}" class="d-block">
        <img src="{{ $product->$showImg }}" alt="{{ $product->getTranslatedAttribute('name') }}" class="img-fluid">
    </a>

    <div class="product-item__status-container">
        @if ($product->isBestseller())
        <span class="product-item__status radius-6 violet-out">{{ __('main.bestseller') }}</span>
        @endif
        {{-- @if ($product->isPromotion())
        <span class="status purple">{{ __('main.promotion') }}</span>
        @endif --}}
        @if ($discounted)
        <span class="product-item__status radius-6 bg-danger">{{ __('main.discount') }} -{{
            $product->discount_percent }}%</span>
        @endif
    </div>


    <a href="{{ $product->url }}" class="product-item__link text-overflow-two-line">{{ $product->getTranslatedAttribute('name') }}</a>

    <p class="product-item__price text-price text-nowrap @if($discounted) mb-0 @else mb-4 @endif">{{ Helper::formatPrice($product->current_price) }}</p>

    @if($discounted)
    <del class="old-price text-nowrap">
        {{ Helper::formatPrice($product->current_not_sale_price) }}
    </del>
    @endif

    <ul class="action-list">
        <li>
            <a href="javascript:;"
                class="radius-8 primary add-to-cart-btn @if (!$product->isAvailable()) disabled @endif only-icon"
                data-id="{{ $product->id }}" data-name="{{ $product->getTranslatedAttribute('name') }}"
                data-price="{{ $product->current_price }}" data-quantity="1"
                data-in-stock="{{ $product->getStock() }}">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="#cart"></use>
                </svg>
            </a>
        </li>
        <li>
            <a href="javascript:;"
                class="radius-8 @if(!app('wishlist')->get($product->id)) add-to-wishlist-btn @else remove-from-wishlist-btn active @endif only-icon"
                data-id="{{ $product->id }}" data-add-url="{{ route('wishlist.add') }}"
                data-remove-url="{{ route('wishlist.delete', $product->id) }}" data-name="{{ $product->getTranslatedAttribute('name') }}"
                data-price="{{ $product->current_price }}"
                data-add-text="<svg width='20' height='20' fill='currentColor'><use xlink:href='#heart'></use></svg>"
                data-delete-text="<svg width='20' height='20' fill='currentColor'><use xlink:href='#heart'></use></svg>">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="#heart"></use>
                </svg>
            </a>
        </li>
        <li>
            <a href="javascript:;"
                class="radius-8 @if(!app('compare')->get($product->id)) add-to-compare-btn @else remove-from-compare-btn active @endif only-icon"
                data-id="{{ $product->id }}" data-name="{{ $product->getTranslatedAttribute('name') }}" data-price="{{ $product->current_price }}"
                data-add-url="{{ route('compare.add') }}"
                data-delete-url="{{ route('compare.delete', ['id' => $product->id]) }}"
                title="@if(!app('compare')->get($product->id)) {{ __('main.add_to_compare') }} @else {{ __('main.delete_from_compare') }} @endif"
                data-add-text="{{ __('main.add_to_compare') }}" data-delete-text="{{ __('main.delete_from_compare') }}">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="#rating"></use>
                </svg>
            </a>
        </li>
    </ul>
</div>
