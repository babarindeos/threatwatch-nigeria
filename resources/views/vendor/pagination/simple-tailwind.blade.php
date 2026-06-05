{{-- resources/views/vendor/pagination/simple-tailwind.blade.php --}}
@if ($paginator->hasPages())
<nav class="flex items-center justify-between gap-3">
    @if ($paginator->onFirstPage())
    <span class="text-sm text-gray-400 font-medium cursor-not-allowed px-4 py-2 border border-gray-200 rounded-xl bg-white">
        ← Previous
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}"
       class="text-sm font-semibold text-gray-700 hover:text-ng-green px-4 py-2
              border border-gray-200 hover:border-ng-green rounded-xl bg-white transition-colors">
        ← Previous
    </a>
    @endif

    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}"
       class="text-sm font-semibold text-gray-700 hover:text-ng-green px-4 py-2
              border border-gray-200 hover:border-ng-green rounded-xl bg-white transition-colors">
        Next →
    </a>
    @else
    <span class="text-sm text-gray-400 font-medium cursor-not-allowed px-4 py-2 border border-gray-200 rounded-xl bg-white">
        Next →
    </span>
    @endif
</nav>
@endif
