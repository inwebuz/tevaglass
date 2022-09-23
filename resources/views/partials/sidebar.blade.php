@php
    if(empty($isCatalogOpen)) {
        $isCatalogOpen = 1;
    }
@endphp

<x-top-catalog :is-open="$isCatalogOpen"></x-top-catalog>

<x-day-product></x-day-product>

<x-discounted-products></x-discounted-products>

<x-banner-sidebar type="sidebar_1"></x-banner-sidebar>

