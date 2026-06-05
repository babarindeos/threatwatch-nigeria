{{-- resources/views/admin/helplines/_form.blade.php --}}
<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900">Helpline Information</h3>

        <div>
            <label class="form-label">Agency Name <span class="text-red-500">*</span></label>
            <input type="text" name="agency_name"
                   value="{{ old('agency_name', $helpline?->agency_name) }}"
                   required placeholder="e.g., Lagos State Police Command"
                   class="form-input @error('agency_name') border-red-400 @enderror">
            @error('agency_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Primary Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone"
                       value="{{ old('phone', $helpline?->phone) }}"
                       required placeholder="e.g., 08012345678"
                       class="form-input @error('phone') border-red-400 @enderror">
                @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Alternate Phone</label>
                <input type="text" name="phone_alt"
                       value="{{ old('phone_alt', $helpline?->phone_alt) }}"
                       placeholder="Optional"
                       class="form-input">
            </div>
        </div>

        <div>
            <label class="form-label">Category <span class="text-red-500">*</span></label>
            <select name="category" required class="form-input @error('category') border-red-400 @enderror">
                <option value="">— Select Category —</option>
                @foreach($categories as $val => $label)
                <option value="{{ $val }}" {{ old('category', $helpline?->category) === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
            @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- National flag --}}
        <label class="flex items-center gap-3 cursor-pointer p-3 bg-blue-50 border border-blue-100 rounded-xl"
               x-data="{ national: {{ old('is_national', $helpline?->is_national ?? false) ? 'true' : 'false' }} }">
            <input type="checkbox" name="is_national" value="1"
                   @click="national = !national"
                   {{ old('is_national', $helpline?->is_national) ? 'checked' : '' }}
                   class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
            <div>
                <p class="text-sm font-semibold text-blue-800">National Helpline</p>
                <p class="text-xs text-blue-600">Available across all of Nigeria, not state-specific.</p>
            </div>
        </label>

        {{-- State / LGA (if not national) --}}
        <div class="grid grid-cols-2 gap-4" x-data="{ national: {{ old('is_national', $helpline?->is_national ?? false) ? 'true' : 'false' }} }">
            <div>
                <label class="form-label">State</label>
                <select name="state_id" id="helpline-state" class="form-input">
                    <option value="">— National / All States —</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ old('state_id', $helpline?->state_id) == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">LGA</label>
                <select name="lga_id" id="helpline-lga"
                        class="form-input {{ $lgas->isEmpty() ? 'opacity-50' : '' }}"
                        {{ $lgas->isEmpty() ? 'disabled' : '' }}>
                    <option value="">— Select LGA —</option>
                    @foreach($lgas as $lga)
                    <option value="{{ $lga->id }}" {{ old('lga_id', $helpline?->lga_id) == $lga->id ? 'selected' : '' }}>
                        {{ $lga->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Address</label>
            <input type="text" name="address"
                   value="{{ old('address', $helpline?->address) }}"
                   placeholder="Physical address (optional)" class="form-input">
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="2"
                      placeholder="Brief description of when to use this helpline..."
                      class="form-input resize-none">{{ old('description', $helpline?->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 items-end">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $helpline?->sort_order ?? 0) }}"
                       class="form-input">
                <p class="text-xs text-gray-400 mt-1">Lower numbers appear first</p>
            </div>
            <div>
                <label class="flex items-center gap-2.5 cursor-pointer mt-3">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $helpline ? $helpline->is_active : true) ? 'checked' : '' }}
                           class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                    <span class="text-sm font-semibold text-gray-700">Active / Visible</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.helplines.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
            Cancel
        </a>
        <button type="submit" class="btn-primary px-7 py-2.5">
            {{ $helpline ? 'Save Changes' : 'Add Helpline' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('helpline-state')?.addEventListener('change', async function() {
    const stateId  = this.value;
    const lgaSelect = document.getElementById('helpline-lga');
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
