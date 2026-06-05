{{-- resources/views/admin/incidents/_form.blade.php --}}
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-5 max-w-4xl">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    {{-- Row 1: Title + Type + Severity --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
            Incident Information
        </h3>

        <div>
            <label class="form-label">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $incident?->title) }}"
                   required placeholder="Clear, descriptive headline"
                   class="form-input @error('title') border-red-400 @enderror">
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label">Attack Type <span class="text-red-500">*</span></label>
                <select name="attack_type" required
                        class="form-input @error('attack_type') border-red-400 @enderror">
                    <option value="">— Select —</option>
                    @foreach($attackTypes as $val => $label)
                    <option value="{{ $val }}" {{ old('attack_type', $incident?->attack_type) === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @error('attack_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Severity <span class="text-red-500">*</span></label>
                <select name="severity" required class="form-input @error('severity') border-red-400 @enderror">
                    <option value="">— Select —</option>
                    @foreach($severities as $sev)
                    <option value="{{ $sev }}" {{ old('severity', $incident?->severity) === $sev ? 'selected' : '' }}>
                        {{ ucfirst($sev) }}
                    </option>
                    @endforeach
                </select>
                @error('severity') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Incident Date <span class="text-red-500">*</span></label>
                <input type="date" name="incident_date"
                       value="{{ old('incident_date', $incident?->incident_date?->format('Y-m-d')) }}"
                       required class="form-input @error('incident_date') border-red-400 @enderror">
                @error('incident_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label">Incident Time</label>
            <input type="time" name="incident_time"
                   value="{{ old('incident_time', $incident?->incident_time) }}"
                   class="form-input sm:w-40">
        </div>

        <div>
            <label class="form-label">Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="6" required
                      placeholder="Full, detailed account of the incident..."
                      class="form-input resize-none @error('description') border-red-400 @enderror">{{ old('description', $incident?->description) }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Source URL</label>
            <input type="url" name="source_url"
                   value="{{ old('source_url', $incident?->source_url) }}"
                   placeholder="https://punchng.com/article/..."
                   class="form-input">
        </div>
    </div>

    {{-- Row 2: Location --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
            Location
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label">State <span class="text-red-500">*</span></label>
                <select name="state_id" id="admin-state-select" required
                        class="form-input @error('state_id') border-red-400 @enderror">
                    <option value="">— Select State —</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}"
                            {{ old('state_id', $incident?->state_id) == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                    @endforeach
                </select>
                @error('state_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">LGA</label>
                <select name="lga_id" id="admin-lga-select"
                        class="form-input" {{ $lgas->isEmpty() ? 'disabled' : '' }}>
                    <option value="">— Select LGA —</option>
                    @foreach($lgas as $lga)
                    <option value="{{ $lga->id }}"
                            {{ old('lga_id', $incident?->lga_id) == $lga->id ? 'selected' : '' }}>
                        {{ $lga->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Town / Village</label>
                <input type="text" name="town"
                       value="{{ old('town', $incident?->town) }}"
                       placeholder="e.g., Kafanchan" class="form-input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Latitude</label>
                <input type="number" name="latitude" step="0.0000001"
                       value="{{ old('latitude', $incident?->latitude) }}"
                       placeholder="e.g., 10.5222" class="form-input">
            </div>
            <div>
                <label class="form-label">Longitude</label>
                <input type="number" name="longitude" step="0.0000001"
                       value="{{ old('longitude', $incident?->longitude) }}"
                       placeholder="e.g., 7.4383" class="form-input">
            </div>
        </div>
    </div>

    {{-- Row 3: Impact + Settings --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
            Impact & Settings
        </h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Fatalities</label>
                <input type="number" name="casualties" min="0"
                       value="{{ old('casualties', $incident?->casualties ?? 0) }}"
                       class="form-input">
            </div>
            <div>
                <label class="form-label">Kidnapped</label>
                <input type="number" name="kidnapped_count" min="0"
                       value="{{ old('kidnapped_count', $incident?->kidnapped_count ?? 0) }}"
                       class="form-input">
            </div>
        </div>

        {{-- Upload images --}}
        <div>
            <label class="form-label">Upload Images / Evidence</label>
            <input type="file" name="images[]" multiple accept="image/*,.pdf"
                   class="form-input py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg
                          file:border-0 file:text-xs file:font-bold file:bg-ng-muted file:text-ng-dark
                          hover:file:bg-ng-100 cursor-pointer">
            @if($incident?->images && count($incident->images))
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach($incident->images as $img)
                <img src="{{ asset('storage/'.$img) }}" class="h-14 w-14 object-cover rounded-lg border border-gray-100" alt="">
                @endforeach
            </div>
            <p class="text-xs text-gray-400 mt-1">Uploading new images will replace existing ones.</p>
            @endif
        </div>

        {{-- Flags --}}
        <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1"
                       {{ old('is_featured', $incident?->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                <span class="text-sm font-medium text-gray-700">Featured Incident</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_anonymous" value="1"
                       {{ old('is_anonymous', $incident?->is_anonymous) ? 'checked' : '' }}
                       class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                <span class="text-sm font-medium text-gray-700">Anonymous Reporter</span>
            </label>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.incidents.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
            Cancel
        </a>
        <button type="submit" class="btn-primary px-7 py-2.5 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ $incident ? 'Save Changes' : 'Create Incident' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('admin-state-select')?.addEventListener('change', async function() {
    const stateId   = this.value;
    const lgaSelect = document.getElementById('admin-lga-select');
    lgaSelect.innerHTML = '<option value="">Loading...</option>';
    lgaSelect.disabled  = true;

    if (!stateId) {
        lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';
        return;
    }

    const res  = await fetch(`{{ route('api.lgas') }}?state_id=${stateId}`);
    const lgas = await res.json();
    lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';
    lgas.forEach(l => lgaSelect.innerHTML += `<option value="${l.id}">${l.name}</option>`);
    lgaSelect.disabled = false;
});
</script>
@endpush
