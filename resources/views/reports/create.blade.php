{{-- ================================================================
     resources/views/reports/create.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Submit Threat Report — ThreatWatch Nigeria')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400
                                              hover:text-ng-green transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        <h1 class="font-display font-bold text-3xl text-gray-900 mb-2">Report a Security Threat</h1>
        <p class="text-sm text-gray-500">Your report will be reviewed by our moderators before publication.</p>
    </div>

    {{-- Disclaimer --}}
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex gap-3">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
        <p class="text-sm text-amber-800">
            <strong>Important:</strong> Only report incidents you have direct knowledge of.
            Filing a false report is a criminal offence under Nigerian law.
        </p>
    </div>

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Section 1: Basic Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-5">
            <h2 class="font-display font-semibold text-base text-gray-900 flex items-center gap-2.5">
                <span class="w-6 h-6 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold flex-shrink-0">1</span>
                Incident Information
            </h2>

            <div>
                <label class="form-label">Title / Headline <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="e.g., Armed bandits attack convoy near Kaduna-Abuja highway"
                       class="form-input @error('title') border-red-400 @enderror">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Attack Type <span class="text-red-500">*</span></label>
                    <select name="attack_type" class="form-input @error('attack_type') border-red-400 @enderror">
                        <option value="">— Select type —</option>
                        @foreach(\App\Models\Incident::ATTACK_TYPES as $val => $label)
                        <option value="{{ $val }}" {{ old('attack_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('attack_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Date of Incident <span class="text-red-500">*</span></label>
                    <input type="date" name="incident_date"
                           value="{{ old('incident_date', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="form-input @error('incident_date') border-red-400 @enderror">
                    @error('incident_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Time (if known)</label>
                <input type="time" name="incident_time" value="{{ old('incident_time') }}"
                       class="form-input sm:w-40">
            </div>

            <div>
                <label class="form-label">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5"
                          placeholder="Describe what happened in detail: events, number of attackers, weapons used, outcome, any other relevant information..."
                          class="form-input resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">Minimum 30 characters. Be as specific as possible.</p>
            </div>
        </div>

        {{-- Section 2: Location --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-5">
            <h2 class="font-display font-semibold text-base text-gray-900 flex items-center gap-2.5">
                <span class="w-6 h-6 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold flex-shrink-0">2</span>
                Location
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">State <span class="text-red-500">*</span></label>
                    <select name="state_id" id="state-select"
                            class="form-input @error('state_id') border-red-400 @enderror">
                        <option value="">— Select State —</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('state_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">LGA</label>
                    <select name="lga_id" id="lga-select" disabled class="form-input disabled:opacity-50">
                        <option value="">— Select State first —</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Town / Village</label>
                    <input type="text" name="town" value="{{ old('town') }}"
                           placeholder="e.g., Kafanchan" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Latitude <span class="text-xs text-gray-400">(optional)</span></label>
                    <input type="number" name="latitude" value="{{ old('latitude') }}"
                           step="0.0000001" placeholder="e.g., 10.5222" class="form-input">
                </div>
                <div>
                    <label class="form-label">Longitude <span class="text-xs text-gray-400">(optional)</span></label>
                    <input type="number" name="longitude" value="{{ old('longitude') }}"
                           step="0.0000001" placeholder="e.g., 7.4383" class="form-input">
                </div>
            </div>
            <p class="text-xs text-gray-400">💡 Tip: You can get coordinates from Google Maps by right-clicking a location.</p>
        </div>

        {{-- Section 3: Impact --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-5">
            <h2 class="font-display font-semibold text-base text-gray-900 flex items-center gap-2.5">
                <span class="w-6 h-6 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold flex-shrink-0">3</span>
                Impact & Evidence
            </h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Fatalities (known)</label>
                    <input type="number" name="casualties" value="{{ old('casualties', 0) }}"
                           min="0" max="99999" class="form-input">
                </div>
                <div>
                    <label class="form-label">Kidnapped (known)</label>
                    <input type="number" name="kidnapped_count" value="{{ old('kidnapped_count', 0) }}"
                           min="0" max="99999" class="form-input">
                </div>
            </div>

            {{-- Evidence upload --}}
            <div>
                <label class="form-label">Evidence Files <span class="text-xs text-gray-400">(optional, max 5)</span></label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-ng-green transition-colors cursor-pointer"
                     onclick="document.getElementById('evidence-upload').click()">
                    <input type="file" id="evidence-upload" name="evidence_files[]"
                           multiple accept="image/*,.pdf,video/mp4" class="hidden"
                           onchange="previewFiles(this)">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-sm text-gray-500"><span class="text-ng-green font-semibold">Click to upload</span> photos, PDF, or video</p>
                    <p class="text-xs text-gray-400 mt-1">Max 10MB per file</p>
                </div>
                <div id="file-list" class="mt-2 space-y-1"></div>
            </div>
        </div>

        {{-- Section 4: Your Details --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
            <h2 class="font-display font-semibold text-base text-gray-900 flex items-center gap-2.5">
                <span class="w-6 h-6 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold flex-shrink-0">4</span>
                Your Details
            </h2>

            <label class="flex items-start gap-3 cursor-pointer" x-data="{ anon: {{ old('is_anonymous') ? 'true' : 'false' }} }">
                <input type="checkbox" name="is_anonymous" value="1"
                       @click="anon = !anon"
                       {{ old('is_anonymous') ? 'checked' : '' }}
                       class="mt-0.5 w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                <div>
                    <p class="text-sm font-semibold text-gray-700">Submit anonymously</p>
                    <p class="text-xs text-gray-500 mt-0.5">Your name won't appear publicly. Identity is still logged for moderation.</p>
                </div>
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ anon: false }">
                <div>
                    <label class="form-label">Your Name <span class="text-xs text-gray-400">(if not anonymous)</span></label>
                    <input type="text" name="reporter_name" value="{{ old('reporter_name', auth()->user()?->full_name) }}"
                           placeholder="Optional" class="form-input">
                </div>
                <div>
                    <label class="form-label">Your Phone <span class="text-xs text-gray-400">(for follow-up)</span></label>
                    <input type="tel" name="reporter_phone" value="{{ old('reporter_phone', auth()->user()?->phone) }}"
                           placeholder="Optional" class="form-input">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('home') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="btn-primary text-sm px-8 py-2.5 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Submit Report
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// LGA dynamic loading
document.getElementById('state-select')?.addEventListener('change', async function() {
    const stateId = this.value;
    const lgaSelect = document.getElementById('lga-select');
    lgaSelect.disabled = true;
    lgaSelect.innerHTML = '<option value="">Loading...</option>';

    if (!stateId) {
        lgaSelect.innerHTML = '<option value="">— Select State first —</option>';
        return;
    }

    try {
        const res  = await fetch(`{{ route('api.lgas') }}?state_id=${stateId}`);
        const lgas = await res.json();

        lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';
        lgas.forEach(lga => {
            lgaSelect.innerHTML += `<option value="${lga.id}">${lga.name}</option>`;
        });
        lgaSelect.disabled = false;
    } catch(e) {
        lgaSelect.innerHTML = '<option value="">Error loading LGAs</option>';
    }
});

// File preview
function previewFiles(input) {
    const list = document.getElementById('file-list');
    list.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 text-xs text-gray-600 bg-gray-50 rounded-lg px-3 py-2';
        div.innerHTML = `
            <svg class="w-3.5 h-3.5 text-ng-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
            <span class="flex-1 truncate">${file.name}</span>
            <span class="text-gray-400">${(file.size/1024).toFixed(0)}KB</span>
        `;
        list.appendChild(div);
    });
}
</script>
@endpush
