{{-- resources/views/partials/incident-card.blade.php --}}
<article class="bg-white rounded-2xl border border-gray-100 overflow-hidden
                card-hover flex flex-col group border border-gray-400">

    {{-- Severity color bar --}}
    <div class="h-1 w-full
        {{ $incident->severity === 'critical' ? 'bg-red-500' :
           ($incident->severity === 'high'     ? 'bg-orange-500' :
           ($incident->severity === 'medium'   ? 'bg-amber-400' : 'bg-emerald-400')) }}">
    </div>

    <div class="p-5 flex flex-col flex-1">

        {{-- Badges row --}}
        <div class="flex items-center gap-2 flex-wrap mb-3">
            <span class="inline-flex text-[11px] font-bold px-2.5 py-1 rounded-lg severity-{{ $incident->severity }}">
                {{ strtoupper($incident->severity) }}
            </span>
            <span class="inline-flex text-[11px] font-medium px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600">
                {{ $incident->attack_type_label }}
            </span>
            @if($incident->is_featured)
            <span class="inline-flex text-[11px] font-bold px-2.5 py-1 rounded-lg bg-yellow-100 text-yellow-700">
                ⭐ Featured
            </span>
            @endif
        </div>

        {{-- Title --}}
        <h3 class="font-display font-semibold text-gray-900 text-sm leading-snug mb-2 line-clamp-2 flex-1">
            <a href="{{ route('incidents.show', $incident->slug) }}"
               class="hover:text-ng-green transition-colors">
                {{ $incident->title }}
            </a>
        </h3>

        {{-- Description --}}
        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
            {{ $incident->short_description }}
        </p>

        {{-- Casualties row --}}
        @if($incident->casualties > 0 || $incident->kidnapped_count > 0)
        <div class="flex items-center gap-3 mb-3">
            @if($incident->casualties > 0)
            <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-lg">
                {{ $incident->casualties }} killed
            </span>
            @endif
            @if($incident->kidnapped_count > 0)
            <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-lg">
                {{ $incident->kidnapped_count }} kidnapped
            </span>
            @endif
        </div>
        @endif

        {{-- Location & date --}}
        <div class="flex items-center justify-between gap-2 text-xs text-gray-400">
            <div class="flex items-center gap-1 min-w-0">
                <svg class="w-3.5 h-3.5 text-ng-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="truncate font-medium text-gray-600">
                    {{ $incident->state->name }}{{ $incident->lga ? ' · ' . $incident->lga->name : '' }}{{ $incident->town ? ', ' . $incident->town : '' }}
                </span>
            </div>
            <span class="flex-shrink-0">{{ $incident->incident_date?->format('d M Y') }}</span>
        </div>
    </div>

    {{-- Card footer --}}
    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
        <span class="text-xs text-gray-500">
            By <span class="font-medium">{{ $incident->reporter_name }}</span>
        </span>
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                {{ number_format($incident->views) }}
            </span>
            <a href="{{ route('incidents.show', $incident->slug) }}"
               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors group-hover:underline">
                Read →
            </a>
        </div>
    </div>
</article>
