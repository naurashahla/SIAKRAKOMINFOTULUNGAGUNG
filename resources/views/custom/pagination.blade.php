@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $showPages = 3; // Jumlah halaman yang ditampilkan di tengah (5, 6, 7)
                $halfShow = 1; // Hanya 1 halaman di kiri dan kanan dari current
            @endphp

            {{-- Always show page 1 --}}
            @if ($last > 1)
                <li class="page-item {{ $current == 1 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
            @endif

            {{-- Show dots if needed before current group --}}
            @if ($current > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Show current page and immediate neighbors --}}
            @php
                $startPage = max(2, $current - $halfShow);
                $endPage = min($last - 1, $current + $halfShow);
                
                // Ensure we don't show page 1 again or last page early
                $startPage = max(2, $startPage);
                $endPage = min($last - 1, $endPage);
                
                // If current is close to start, show more pages after
                if ($current <= 3) {
                    $startPage = 2;
                    $endPage = min($last - 1, 4);
                }
                
                // If current is close to end, show more pages before  
                if ($current >= $last - 2) {
                    $startPage = max(2, $last - 3);
                    $endPage = $last - 1;
                }
            @endphp

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page != 1 && $page != $last)
                    @if ($page == $current)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endif
            @endfor

            {{-- Show dots if needed after current group --}}
            @if ($current < $last - 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Always show last page if more than 1 page --}}
            @if ($last > 1)
                <li class="page-item {{ $current == $last ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">></span>
                </li>
            @endif
        </ul>
    </nav>
@endif