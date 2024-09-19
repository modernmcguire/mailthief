<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

        <nav>
            <ul class="pagination pagination-sm justify-content-center text-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="w-100 page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="w-100 page-link" aria-hidden="true">Previous</span>
                    </li>
                @else
                    <li class="w-100 page-item">
                        <button class="w-100 page-link" type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">Previous</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="w-100 page-item disabled" aria-disabled="true">
                            <span class="w-100 page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="w-100 page-item active" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}" aria-current="page">
                                    <span class="w-100 page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="w-100 page-item" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}">
                                    <button type="button" class="w-100 page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="w-100 page-item">
                        <button class="w-100 page-link" type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">Next</button>
                    </li>
                @else
                    <li class="w-100 page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="w-100 page-link" aria-hidden="true">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
