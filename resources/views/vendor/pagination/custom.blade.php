@php
    $showPages = 2;
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $startPage = max(1, $currentPage - $showPages);
    $endPage = min($lastPage, $currentPage + $showPages);
    $hasMoreStart = $startPage > 1;
    $hasMoreEnd = $endPage < $lastPage;
@endphp

@if ($paginator->hasPages())
<div x-data x-init="$nextTick(() => {
    let active = $el.querySelector('.page-item.active a');
    if (active) {
        active.scrollIntoView({block: 'nearest', inline: 'center'});
    }
})" class="w-full">
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        <ul class="inline-flex items-center -space-x-px">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="block px-3 py-2 ml-2 leading-tight text-stone-400 bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-l-[10px] cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                </li>
            @else
                <li>
                    <button type="button" wire:click="previous-page" wire:loading.attr="disabled"
                        class="block px-3 py-2 ml-2 leading-tight text-stone-700 dark:text-stone-300 bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-l-[10px] hover:bg-stone-50 dark:hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-[#F1641E] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                </li>
            @endif

            {{-- First Page --}}
            @if ($currentPage > $showPages + 1)
                <li>
                    <button type="button" wire:click="page(1)" class="page-item">
                        <span class="px-3 py-2 leading-tight border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-stone-800 hover:text-stone-900 dark:hover:text-white transition">1</span>
                    </button>
                </li>
            @endif

            {{-- "More" Start --}}
            @if ($hasMoreStart)
                <li>
                    <span class="px-3 py-2 leading-tight border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] text-stone-400 dark:text-stone-500">…</span>
                </li>
            @endif

            {{-- Page Links --}}
            @foreach (range($startPage, $endPage) as $page)
                <li>
                    @if ($page == $currentPage)
                        <button type="button" wire:click="page({{ $page }})"
                            class="page-item active">
                            <span class="px-3 py-2 border border-[#F1641E] bg-[#F1641E] text-white hover:bg-[#d95716] focus:outline-none focus:ring-2 focus:ring-[#F1641E] transition">{{ $page }}</span>
                        </button>
                    @else
                        <button type="button" wire:click="page({{ $page }})"
                            class="page-item">
                            <span class="px-3 py-2 leading-tight border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-stone-800 hover:text-stone-900 dark:hover:text-white transition">{{ $page }}</span>
                        </button>
                    @endif
                </li>
            @endforeach

            {{-- "More" End --}}
            @if ($hasMoreEnd)
                <li>
                    <span class="px-3 py-2 leading-tight border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] text-stone-400 dark:text-stone-500">…</span>
                </li>
            @endif

            {{-- Last Page --}}
            @if ($endPage < $lastPage)
                <li>
                    <button type="button" wire:click="page({{ $lastPage }})" class="page-item">
                        <span class="px-3 py-2 leading-tight border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-stone-800 hover:text-stone-900 dark:hover:text-white transition">{{ $lastPage }}</span>
                    </button>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" wire:click="next-page" wire:loading.attr="disabled"
                        class="block px-3 py-2 leading-tight text-stone-700 dark:text-stone-300 bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-r-[10px] hover:bg-stone-50 dark:hover:bg-stone-800 hover:text-stone-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-[#F1641E] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </li>
            @else
                <li>
                    <span class="block px-3 py-2 leading-tight text-stone-400 bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-r-[10px] cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
</div>
@endif
