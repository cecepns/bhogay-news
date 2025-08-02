@if ($paginator->hasPages())
    <div class="flex-wr-s-c m-rl--7 p-t-15">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7" rel="prev">
                <i class="fa fa-angle-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        @endif
    </div>
@endif 