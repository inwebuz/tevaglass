<div class="brand-one d-flex align-items-center justify-content-center">
    <a href="{{ $brand->url }}" class="d-block" title="{{ $brand->getTranslatedAttribute('name') }}">
        @if($brand->image)
        <img src="{{ $brand->small_img }}" alt="{{ $brand->getTranslatedAttribute('name') }}" class="img-fluid">
        @else
        <div class="template-img text-dark d-flex align-items-center font-weight-bold">{{ $brand->getTranslatedAttribute('name') }}</div>
        @endif
    </a>
</div>
