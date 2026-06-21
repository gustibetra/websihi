{{-- Always show pagination, even with 1 page --}}
<div class="col-sm-auto">
    <ul class="pagination pagination-separated pagination-sm justify-content-center justify-content-sm-start mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">←</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev">←</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @if(isset($elements) && is_array($elements))
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @else
            {{-- Always show at least current page --}}
            <li class="page-item active">
                <span class="page-link">{{ $paginator->currentPage() }}</span>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">→</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">→</span>
            </li>
        @endif
    </ul>
</div>

