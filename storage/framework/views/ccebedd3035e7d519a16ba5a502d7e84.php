<?php $__env->startSection('title', 'Security Incidents — ThreatWatch Nigeria'); ?>
<?php $__env->startSection('meta_description', 'Browse all verified security incidents across Nigeria. Filter by state, attack type, and severity.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display font-bold text-3xl text-gray-900">Security Incidents</h1>
            <p class="text-sm text-gray-500 mt-1.5">
                <?php echo e(number_format($incidents->total())); ?> verified report<?php echo e($incidents->total() !== 1 ? 's' : ''); ?> from across Nigeria
            </p>
        </div>
        <a href="<?php echo e(route('reports.create')); ?>"
           class="inline-flex items-center gap-2 bg-ng-green hover:bg-ng-dark text-white
                  font-bold text-sm px-5 py-2.5 rounded-xl transition-colors shadow-sm flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Report a Threat
        </a>
    </div>

    
    <form method="GET" action="<?php echo e(route('incidents.index')); ?>"
          class="bg-white rounded-2xl border border-gray-100 p-4 mb-6 shadow-sm"
          x-data="{ showAdvanced: <?php echo e((!empty($filters['date_from']) || !empty($filters['date_to']) || !empty($filters['search'])) ? 'true' : 'false'); ?> }">

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            
            <div>
                <label class="form-label text-xs">State</label>
                <select name="state_id" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg"
                        onchange="loadLgas(this.value)">
                    <option value="">All States</option>
                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($state->id); ?>" <?php echo e(($filters['state_id'] ?? '') == $state->id ? 'selected' : ''); ?>>
                        <?php echo e($state->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="form-label text-xs">Attack Type</label>
                <select name="attack_type" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = \App\Models\Incident::ATTACK_TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(($filters['attack_type'] ?? '') === $val ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="form-label text-xs">Severity</label>
                <select name="severity" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg">
                    <option value="">All Levels</option>
                    <?php $__currentLoopData = ['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(($filters['severity'] ?? '') === $val ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div class="flex items-end items-center">
                <button type="submit" class="btn-primary w-full border bg-green-600 text-white rounded-lg hover:bg-green-700 py-1">Filter</button>
            </div>

            
            <div class="flex items-end">
                <button type="button" @click="showAdvanced = !showAdvanced"
                        class="w-full text-xs font-semibold text-gray-500 hover:text-ng-green
                               border border-gray-200 rounded-xl px-3 py-2 transition-colors">
                    <span x-text="showAdvanced ? 'Less filters ▲' : 'More filters ▼'"></span>
                </button>
            </div>
        </div>

        
        <div x-show="showAdvanced" x-collapse class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3 pt-3 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <label class="form-label text-xs">Search</label>
                <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>"
                       placeholder="Keywords in title or description..."
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg flex-1 px-2">
            </div>
            <div>
                <label class="form-label text-xs">Date From</label>
                <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>"
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg px-2">
            </div>
            <div>
                <label class="form-label text-xs">Date To</label>
                <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>"
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg px-2">
            </div>
        </div>

        
        <?php if(array_filter($filters)): ?>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs text-gray-500 font-medium">Active filters:</span>
            <?php $__currentLoopData = array_filter($filters); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="inline-flex items-center gap-1 text-xs bg-ng-muted text-ng-dark
                         border border-ng-green/20 px-2.5 py-1 rounded-full font-medium">
                <?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>: <?php echo e($value); ?>

            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('incidents.index')); ?>"
               class="ml-auto text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">
                ✕ Clear all
            </a>
        </div>
        <?php endif; ?>
    </form>

    
    <?php if($incidents->isEmpty()): ?>
    <div class="text-center py-20">
        <svg class="w-14 h-14 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="font-display font-bold text-lg text-gray-400">No incidents found</p>
        <p class="text-sm text-gray-400 mt-1">Try adjusting your filters</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php $__currentLoopData = $incidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.incident-card', ['incident' => $incident], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="mt-8">
        <?php echo e($incidents->withQueryString()->links()); ?>

    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/incidents/index.blade.php ENDPATH**/ ?>