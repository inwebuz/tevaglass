<ul class="sidebar-collapse__list">
    @foreach ($categories as $category)
    @php
        $isOpen = $category->id == $activeCategoryId || count($categories) == 1 ? true : false;
    @endphp
    <li>
        <a href="{{ $brand ? route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $category->getTranslatedAttribute('slug') ?? $category->slug]) : $category->url }}" @if (!$category->children->isEmpty()) data-toggle="collapse" @endif class="@if($isOpen) open @endif">
            {{-- <span class="category-svg-icon">
                {!! $category->svg_icon_img !!}
            </span> --}}
            <svg width="10" height="10" fill="#000" class="arrow">
                <use xlink:href="#arrow"></use>
            </svg>
            <span>{{ $category->getTranslatedAttribute('name') }}</span>
        </a>
        @if (!$category->children->isEmpty())
        <ul class="collapse @if($isOpen) show @endif">
            @foreach ($category->children as $subcategory)
            <li>
                <a href="{{ $brand ? route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $subcategory->getTranslatedAttribute('slug') ?? $subcategory->slug]) : $subcategory->url }}" class="@if($subcategory->id == $activeCategoryId) active @endif">{{ $subcategory->getTranslatedAttribute('name') }}</a>
            </li>
            @endforeach
        </ul>
        {{-- <span class="show-subcategories-m" data-category-id="{{ $category->id }}">
            <svg width="16" height="16" fill="#999">
                <use xlink:href="#arrow"></use>
            </svg>
        </span> --}}
        @endif
    </li>
    @endforeach
</ul>
