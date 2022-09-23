@if(!empty($breadcrumbs))
    <ul class="intro__bread">
        @foreach($breadcrumbs->getItems() as $link)
            @if($link->isActive())
                <li>
                    <a href="{{ $link->url }}">{{ $link->name }}</a>
                </li>
            @else
                <li>
                    <span>{{ $link->name }}</span>
                </li>
            @endif
        @endforeach
    </ul>
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadcrumbs->getItems() as $link)
                @if($link->isActive())
                    <li class="breadcrumb-item">
                        <a href="{{ $link->url }}">{{ $link->name }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>{{ $link->name }}</span>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav> --}}
@endif
