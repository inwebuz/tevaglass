@if ($paginator->hasPages())
<div class="pagination">
    <ul class="pagination__list">

        @if ($paginator->onFirstPage())
            <li class="pagination__nav prev">
                <span>Prev</span>
            </li>
        @else
            <li class="pagination__nav prev">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a>
            </li>
        @endif

        @foreach ($elements as $element)

            {{-- "Three Dots" Separator --}}
            {{-- @if (is_string($element))
                <li><span class="">{{ $element }}</span></li>
            @endif --}}

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination__count active">
                            <span>{{ $page }}</span>
                        </li>
                    @else
                        <li class="pagination__count">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="pagination__nav next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="pagination__nav next">
                <span>Next</span>
            </li>
        @endif
    </ul>
</div>
@endif
