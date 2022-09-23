@extends('layouts.app')

@php
$seoReplacements = [
    'brand_name' => $brand->getTranslatedAttribute('name'),
    'category_name' => $category->getTranslatedAttribute('name'),
    'products_quantity' => $category->products()->active()->where('brand_id', $brand->id)->count(),
    'min_price' => Helper::formatPrice($category->products()->active()->where('brand_id', $brand->id)->min('price')),
    'max_price' => Helper::formatPrice($category->products()->active()->where('brand_id', $brand->id)->max('price')),
    'year' => date('Y'),
];
@endphp

@section('seo_title', $brandCategoryText && $brandCategoryText->getTranslatedAttribute('seo_title') ?? Helper::seo('brand_category', 'seo_title', $seoReplacements))
@section('meta_description', $brandCategoryText && $brandCategoryText->getTranslatedAttribute('meta_description') ?? Helper::seo('brand_category', 'meta_description', $seoReplacements))
@section('meta_keywords', $brandCategoryText && $brandCategoryText->getTranslatedAttribute('meta_keywords') ?? Helper::seo('brand_category', 'meta_keywords', $seoReplacements))
@section('body_class', 'category-brand-page')
@section('microdata')
{!! $microdata !!}
@endsection

@section('content')

@php
$siteLogo = setting('site.logo');
$logo = $siteLogo ? Voyager::image($siteLogo) : '/img/logo.png';
$siteTitle = setting('site.title')
@endphp

<main class="main">

    <div class="container">
        @can('edit', $category)
        <div class="my-4">
            <a href="{{ url('admin/categories/' . $category->id . '/edit') }}" class="btn btn-lg btn-primary"
                target="_blank">Редактировать категорию (ID: {{ $category->id }})</a>
        </div>
        @endcan
    </div>

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container">
        <x-banner-category type="category_top" :category-id="$category->id"></x-banner-category>
    </div>

    <section class="category">
        <div class="container">
            <h1>{{ $brandCategoryText && $brandCategoryText->getTranslatedAttribute('h1_name') ?? Helper::seo('brand_category', 'h1_name', $seoReplacements) }}</h1>
            <div class="row category-wrap">
                <div class="col-lg-20 col-12">
                    <aside class="sidebar sticky-top catalog-sidebar">
                        <form action="{{ route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $category->getTranslatedAttribute('slug') ?? $category->slug]) }}" class="category-main-form filter-form">

                            <input type="hidden" name="sort" value="{{ $sortCurrent }}">
                            <input type="hidden" name="product_view" value="{{ $productView }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">

                            <x-sidebar-categories :active-category-id="$category->id" :category-id="$category->parent_id" :brand-id="$brand->id"></x-sidebar-categories>

                            @php
                            $categoryPricesFrom = floor((isset($categoryPrices['from']) ? (int)$categoryPrices['from'] :
                            (int)$categoryPrices['min']) / 1000) * 1000;
                            $categoryPricesTo = ceil((isset($categoryPrices['to']) ? (int)$categoryPrices['to'] :
                            (int)$categoryPrices['max']) / 1000) * 1000;
                            $categoryPricesMin = floor(((int)$categoryPrices['min']) / 1000) * 1000;
                            $categoryPricesMax = ceil(((int)$categoryPrices['max']) / 1000) * 1000;
                            @endphp

                            @if(!$products->isEmpty())
                            <div class="filter-form__item mb-4">
                                <h4>{{ __('main.price') }}</h4>
                                <strong>
                                    <span id="price-range-filter-from">{{ number_format($categoryPricesFrom, 0, '.', ' ') }}</span> - <span id="price-range-filter-to">{{ number_format($categoryPricesTo, 0, '.', ' ') }}</span>
                                </strong>
                                <label class="range-item">
                                    <input type="range" name="price[from]" min="{{ $categoryPricesMin }}"
                                        max="{{ $categoryPricesMax }}" value="{{ $categoryPricesFrom }}"
                                        class="range-control range-control-from" step="1000">
                                    <input type="range" name="price[to]" min="{{ $categoryPricesMin }}"
                                        max="{{ $categoryPricesMax }}" value="{{ $categoryPricesTo }}"
                                        class="range-control range-control-to" step="1000">
                                </label>
                                {{-- <div class="mt-4"><button class="btn btn-sm btn-outline-secondary" type="submit">{{
                                        __('main.form.apply') }}</button></div> --}}
                            </div>
                            @endif

                            @if(!$categoryAttributes->isEmpty())
                            @foreach($categoryAttributes as $attribute)
                            <div class="filter-form__item mb-4" id="filter-attribute-{{ $attribute->id }}">
                                <h5>{{ $attribute->getTranslatedAttribute('name') }}</h5>
                                <div class="form-group" data-target="more-container">
                                    @foreach($attribute->attributeValues as $key => $attributeValue)
                                    @php
                                    $isAttrValueActive = (!empty($attributes[$attribute->id]) &&
                                    is_array($attributes[$attribute->id]) && in_array($attributeValue->id,
                                    $attributes[$attribute->id])) ? true : false;
                                    @endphp
                                    <div class="custom-checkbox__item">
                                        <input type="checkbox" class="category-filter-checkbox custom-checkbox"
                                            name="attribute[{{ $attribute->id }}][]" value="{{ $attributeValue->id }}"
                                            id="attribute_value_{{ $attributeValue->id }}" @if ($isAttrValueActive)
                                            checked @endif>
                                        <label class="custom-checkbox-label"
                                            for="attribute_value_{{ $attributeValue->id }}">{{ $attributeValue->getTranslatedAttribute('name')
                                            }}</label>
                                    </div>
                                    @endforeach

                                    <div class="help-block"></div>
                                </div>
                                @if($attribute->attributeValues->count() > 3) <a href="javascript:;" class="text-gray" data-toggle="more-btn" data-max="520">{{
                                    __('main.show_more') }}</a> @endif
                            </div>
                            @endforeach
                            @endif

                            {{-- <div class="mt-4 mb-5">
                                <a class="theme-btn radius-6 sm" href="{{ $category->url }}">{{ __('main.show_all') }}</a>
                            </div> --}}

                        </form>
                    </aside>
                </div>
                <div class="col-lg-80 col-12">
                    <article class="category-content">
                        <div class="text-block">
                            <p>{{ $brandCategoryText && $brandCategoryText->getTranslatedAttribute('description') ?? Helper::seo('brand_category', 'description', $seoReplacements) }}</p>
                        </div>

                        @if(!$products->isEmpty())
                        <div class="sort-nav my-4 d-none d-lg-flex">
                            <strong class="text-black">{{ $showingResults }}</strong>
                            <ul class="sort-nav__list ml-auto">
                                @foreach($sorts as $sort)
                                <li>
                                    <a href="javascript:;" data-value="{{ $sort }}" class="btn-sm radius-6 change-sort-dropdown-item @if($sortCurrent != $sort) outline @endif">{!! __('main.sort.' . $sort) !!}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row align-items-center my-3 d-lg-none">
                            <div class="col-6">
                                <button class="category-filters-switch btn btn-primary radius-6 w-100">{{ __('main.filters') }}</button>
                            </div>
                            <div class="col-6">
                                @if(!$products->isEmpty())
                                    <div class="sort-dropdown dropdown">
                                        <a href="javascript:;" class="dropdown-toggle justify-content-center text-gray" data-toggle="dropdown">
                                            <span>{{ __('main.sorting') }}</span>
                                            <svg width="12" height="12" fill="#666" class="arrow">
                                                <use xlink:href="#arrow-down"></use>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu right">
                                            @foreach($sorts as $sort)
                                            <a href="javascript:;" data-value="{{ $sort }}"
                                                class="dropdown-item change-sort-dropdown-item @if($sortCurrent == $sort) active @endif">{!!
                                                __('main.sort.' . $sort) !!}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (!$subcategories->isEmpty())
                        <nav class="navbar-m d-lg-none">
                            <ul class="navbar-m__list">
                                <li class="navbar-m__item">
                                    <a href="#" class="navbar-m__link" data-toggle-menu="category-menu">
                                        <svg width="30" height="30" stroke="#1a2c3c">
                                            <use xlink:href="#menu"></use>
                                        </svg>
                                        <span>{{ __('main.categories') }}</span>
                                        <svg width="18" height="18" fill="#999">
                                            <use xlink:href="#arrow"></use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        @endif

                        <div class="row products-wrap">
                            @forelse ($products as $product)
                            <div class="col-lg-3 col-md-4 col-6 product-item__parent">
                                @include('partials.product_one')
                            </div>
                            @empty
                            @php
                            $noProductsText = Helper::staticText('no_products_text')->getTranslatedAttribute('description') ?? '';
                            @endphp
                            <div class="col-12 text-center">
                                <div class="p-4">
                                    {!! $noProductsText !!}
                                </div>
                            </div>
                            @endforelse
                        </div>

                        @if(!$products->isEmpty())
                        <div class="content-bottom">

                            {!! $links !!}

                            <div class="visited-dropdown dropdown ml-auto d-none d-lg-flex">
                                <a href="javascript:;" class="dropdown-toggle radius-6" data-toggle="dropdown">
                                    <span>{{ $quantity }}</span>
                                    <svg width="13" height="13" fill="#010101" class="arrow">
                                        <use xlink:href="#arrow-down"></use>
                                    </svg>
                                </a>
                                <div class="dropdown-menu">
                                    @foreach($quantityPerPage as $value)
                                    <a href="javascript:;" data-value="{{ $value }}"
                                        class="change-per-page-dropdown-item dropdown-item @if($quantity == $value) active @endif">{{
                                        $value }}</a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <x-banner-category type="category_bottom" :category-id="$category->id"></x-banner-category>
    </div>

    <section class="about text-block">
        <div class="container">
            {!! $brandCategoryText && $brandCategoryText->getTranslatedAttribute('body') ?? Helper::seo('brand_category', 'body', $seoReplacements) !!}
        </div>
    </section>

</main>

@if (!$subcategories->isEmpty())
<div class="category-menu" data-target-menu="category-menu">
    <div class="category-menu__header">
        <button type="button" data-toggle="menu-close">
            <svg width="24" height="24" fill="#333">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ $logo }}" alt="{{ $siteTitle }}" class="img-fluid">
            </a>
        </div>
    </div>
    <div class="category-menu__content">
        <div class="category-menu__body">
            <ul class="category-menu__list">
                @foreach ($subcategories as $subcategory)
                <li>
                    <a href="{{ route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $subcategory->getTranslatedAttribute('slug') ?? $subcategory->slug]) }}" class="text-uppercase">
                        <span>{{ $subcategory->getTranslatedAttribute('name') }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
{{-- <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('js/TweenMax.min.js') }}"></script> --}}
<script>
    $(function(){
            let shopContainerView = localStorage.getItem('shopContainerView');
            if (!shopContainerView) {
                shopContainerView = 'list';
            }
            $('.shop_container').removeClass('list').removeClass('grid').addClass(shopContainerView);
            $('.shop_container_icon.' + shopContainerView).addClass('active').siblings().removeClass('active');


            let form = $('.category-main-form');
            $('.category-filter-checkbox').on('change', function(e){
                form.submit();
            });
            $('.change-sort-select').on('change', function(){
                let newValue = $(this).val();
                form.find('[name="sort"]').val(newValue);
                form.submit();
            });

            /* price range */
            $('.range-control-from').on('input', function(){
                let newValue = +$(this).val();
                $('#price-range-filter-from').text(newValue.toLocaleString('ru-RU'));
            });
            $('.range-control-from').on('change', function(){
                // let newValue = $(this).val();
                // form.find('[name="from"]').val(newValue);
                form.submit();
            });
            $('.range-control-to').on('input', function(){
                let newValue = +$(this).val();
                $('#price-range-filter-to').text(newValue.toLocaleString('ru-RU'));
            });
            $('.range-control-to').on('change', function(){
                // let newValue = $(this).val();
                // form.find('[name="to"]').val(newValue);
                form.submit();
            });

            $('.change-sort-dropdown-item').on('click', function(e){
                e.preventDefault();
                if ($(this).hasClass('active')) {
                    return;
                }
                // $('#change-sort-dropdown-btn').text($(this).text());
                $(this).parent().find('.active').removeClass('active');
                $(this).addClass('active');
                let newValue = $(this).data('value');
                form.find('[name="sort"]').val(newValue);
                form.submit();
            });
            $('.change-per-page-select').on('change', function(){
                let newValue = $(this).val();
                form.find('[name="quantity"]').val(newValue);
                form.submit();
            });
            $('.change-per-page-dropdown-item').on('click', function(e){
                e.preventDefault();
                if ($(this).hasClass('active')) {
                    return;
                }
                // $('#change-sort-dropdown-btn').text($(this).text());
                $(this).parent().find('.active').removeClass('active');
                $(this).addClass('active');
                let newValue = $(this).data('value');
                form.find('[name="quantity"]').val(newValue);
                form.submit();
            });
            $('.side-box-list-switch').on('click', function(e){
                e.preventDefault();
                $(this).toggleClass('active');
                let targetIdHash = $(this).attr('href');
                let target = $(targetIdHash);
                if (target.length) {
                    target.find('.category-filter-row-visibility-changable').toggleClass('d-none');
                }
            });

            $('.product-list-view-change').on('click', function(e){
                e.preventDefault();
                if ($(this).hasClass('active')) {
                    return;
                }
                $(this).parent().find('.active').removeClass('active');
                $(this).addClass('active');
                let newValue = $(this).data('product-view');
                form.find('[name="product_view"]').val(newValue);
                form.submit();
            });

            $('.category-filters-box .side-box .box-header').on('click', function(){
                let parentBox = $(this).closest('.side-box');
                if (!parentBox.length) {
                    return;
                }
                parentBox.toggleClass('active inactive');
                // let boxList = parentBox.find('.side-box-list');
                // if (boxList.length) {
                //     boxList.toggleClass('active');
                // }
            });

        }); // ready end
</script>
@endsection
