@if ($paginator->hasPages())
    <nav aria-label="Pagination" class="d-flex align-items-center justify-content-between gap-2">
        <div class="small text-muted">
            @php
                $from = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
                $to   = min($paginator->currentPage() * $paginator->perPage(), $paginator->total());
            @endphp
            Hiển thị {{ $from }}–{{ $to }} / {{ $paginator->total() }}
        </div>
        
        <ul class="pagination mb-0">
            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Trang trước">&laquo;</a>
                </li>
            @endif
            
            {{-- Elements --}}
            @foreach ($elements as $element)
                {{-- Dấu ... --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif
                
                {{-- Các số trang --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            
            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Trang sau">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
