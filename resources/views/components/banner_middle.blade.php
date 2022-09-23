@if ($banner)
<a href="{{ $banner->getTranslatedAttribute('url') }}" class="radius-b-box radius-10 overflow-hidden">
    <img src="{{ $banner->img }}" alt="{{ $banner->getTranslatedAttribute('name') }}" class="img-fluid">
</a>
@endif
