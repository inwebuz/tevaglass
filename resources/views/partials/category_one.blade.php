<a href="{{ $category->url }}" class="categories-item radius-12">
    <img src="{{ $category->small_img }}" alt="{{ $category->getTranslatedAttribute('name') }}" class="img-fluid">
    <b>{{ $category->getTranslatedAttribute('name') }}</b>
</a>
