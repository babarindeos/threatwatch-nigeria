
<form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="space-y-5 max-w-4xl">
    <?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?> <?php echo method_field($method); ?> <?php endif; ?>

    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
            Incident Information
        </h3>

        <div>
            <label class="form-label">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="<?php echo e(old('title', $incident?->title)); ?>"
                   required placeholder="Clear, descriptive headline"
                   class="form-input <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label">Attack Type <span class="text-red-500">*</span></label>
                <select name="attack_type" required
                        class="form-input <?php $__errorArgs = ['attack_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">— Select —</option>
                    <?php $__currentLoopData = $attackTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(old('attack_type', $incident?->attack_type) === $val ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['attack_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">Severity <span class="text-red-500">*</span></label>
                <select name="severity" required class="form-input <?php $__errorArgs = ['severity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">— Select —</option>
                    <?php $__currentLoopData = $severities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sev); ?>" <?php echo e(old('severity', $incident?->severity) === $sev ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($sev)); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['severity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">Incident Date <span class="text-red-500">*</span></label>
                <input type="date" name="incident_date"
                       value="<?php echo e(old('incident_date', $incident?->incident_date?->format('Y-m-d'))); ?>"
                       required class="form-input <?php $__errorArgs = ['incident_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['incident_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div>
            <label class="form-label">Incident Time</label>
            <input type="time" name="incident_time"
                   value="<?php echo e(old('incident_time', $incident?->incident_time)); ?>"
                   class="form-input sm:w-40">
        </div>

        <div>
            <label class="form-label">Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="6" required
                      placeholder="Full, detailed account of the incident..."
                      class="form-input resize-none <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $incident?->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="form-label">Source URL</label>
            <input type="url" name="source_url"
                   value="<?php echo e(old('source_url', $incident?->source_url)); ?>"
                   placeholder="https://punchng.com/article/..."
                   class="form-input">
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
            Location
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label">State <span class="text-red-500">*</span></label>
                <select name="state_id" id="admin-state-select" required
                        class="form-input <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">— Select State —</option>
                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($state->id); ?>"
                            <?php echo e(old('state_id', $incident?->state_id) == $state->id ? 'selected' : ''); ?>>
                        <?php echo e($state->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">LGA</label>
                <select name="lga_id" id="admin-lga-select"
                        class="form-input" <?php echo e($lgas->isEmpty() ? 'disabled' : ''); ?>>
                    <option value="">— Select LGA —</option>
                    <?php $__currentLoopData = $lgas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lga->id); ?>"
                            <?php echo e(old('lga_id', $incident?->lga_id) == $lga->id ? 'selected' : ''); ?>>
                        <?php echo e($lga->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="form-label">Town / Village</label>
                <input type="text" name="town"
                       value="<?php echo e(old('town', $incident?->town)); ?>"
                       placeholder="e.g., Kafanchan" class="form-input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Latitude</label>
                <input type="number" name="latitude" step="0.0000001"
                       value="<?php echo e(old('latitude', $incident?->latitude)); ?>"
                       placeholder="e.g., 10.5222" class="form-input">
            </div>
            <div>
                <label class="form-label">Longitude</label>
                <input type="number" name="longitude" step="0.0000001"
                       value="<?php echo e(old('longitude', $incident?->longitude)); ?>"
                       placeholder="e.g., 7.4383" class="form-input">
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
        <h3 class="font-display font-semibold text-sm text-gray-900 flex items-center gap-2">
            <span class="w-5 h-5 bg-ng-green text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
            Impact & Settings
        </h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Fatalities</label>
                <input type="number" name="casualties" min="0"
                       value="<?php echo e(old('casualties', $incident?->casualties ?? 0)); ?>"
                       class="form-input">
            </div>
            <div>
                <label class="form-label">Kidnapped</label>
                <input type="number" name="kidnapped_count" min="0"
                       value="<?php echo e(old('kidnapped_count', $incident?->kidnapped_count ?? 0)); ?>"
                       class="form-input">
            </div>
        </div>

        
        <div>
            <label class="form-label">Upload Images / Evidence</label>
            <input type="file" name="images[]" multiple accept="image/*,.pdf"
                   class="form-input py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg
                          file:border-0 file:text-xs file:font-bold file:bg-ng-muted file:text-ng-dark
                          hover:file:bg-ng-100 cursor-pointer">
            <?php if($incident?->images && count($incident->images)): ?>
            <div class="mt-2 flex flex-wrap gap-2">
                <?php $__currentLoopData = $incident->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(asset('storage/'.$img)); ?>" class="h-14 w-14 object-cover rounded-lg border border-gray-100" alt="">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <p class="text-xs text-gray-400 mt-1">Uploading new images will replace existing ones.</p>
            <?php endif; ?>
        </div>

        
        <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1"
                       <?php echo e(old('is_featured', $incident?->is_featured) ? 'checked' : ''); ?>

                       class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                <span class="text-sm font-medium text-gray-700">Featured Incident</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_anonymous" value="1"
                       <?php echo e(old('is_anonymous', $incident?->is_anonymous) ? 'checked' : ''); ?>

                       class="w-4 h-4 text-ng-green border-gray-300 rounded focus:ring-ng-green">
                <span class="text-sm font-medium text-gray-700">Anonymous Reporter</span>
            </label>
        </div>
    </div>

    
    <div class="flex items-center justify-end gap-3">
        <a href="<?php echo e(route('admin.incidents.index')); ?>"
           class="text-sm text-gray-500 hover:text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
            Cancel
        </a>
        <button type="submit" class="btn-primary px-7 py-2.5 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <?php echo e($incident ? 'Save Changes' : 'Create Incident'); ?>

        </button>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
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

    const res  = await fetch(`<?php echo e(route('api.lgas')); ?>?state_id=${stateId}`);
    const lgas = await res.json();
    lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';
    lgas.forEach(l => lgaSelect.innerHTML += `<option value="${l.id}">${l.name}</option>`);
    lgaSelect.disabled = false;
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/incidents/_form.blade.php ENDPATH**/ ?>