{{-- resources/views/vendor/pagination/tailwind.blade.php --}}
@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">

    {{-- Mobile: Previous/Next only --}}
    <div class="flex flex-1 justify-between sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                     bg-white border border-gray-200 rounded-xl cursor-not-allowed">
            ← Previous
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700
                  bg-white border border-gray-200 rounded-xl hover:border-ng-green hover:text-ng-green transition-colors">
            ← Previous
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700
                  bg-white border border-gray-200 rounded-xl hover:border-ng-green hover:text-ng-green transition-colors">
            Next →
        </a>
        @else
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                     bg-white border border-gray-200 rounded-xl cursor-not-allowed">
            Next →
        </span>
        @endif
    </div>

    {{-- Desktop: Full pagination --}}
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500">
                Showing
                <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300
                             bg-white border-r border-gray-200 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600
                          bg-white border-r border-gray-200 hover:bg-ng-muted hover:text-ng-green transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    {{-- Dots --}}
                    @if (is_string($element))
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                                 bg-white border-r border-gray-200">
                        {{ $element }}
                    </span>
                    @endif

                    {{-- Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold
                                         text-white bg-ng-green border-r border-ng-dark z-10"
                                  aria-current="page">
                                {{ $page }}
                            </span>
                            @else
                            <a href="{{ $url }}"
                               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600
                                      bg-white border-r border-gray-200 hover:bg-ng-muted hover:text-ng-green transition-colors">
                                {{ $page }}
                            </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600
                          bg-white hover:bg-ng-muted hover:text-ng-green transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300
                             bg-white cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
