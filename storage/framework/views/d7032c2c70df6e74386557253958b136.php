<?php $__env->startSection('title', 'Manage Incidents'); ?>
<?php $__env->startSection('page_title', 'Incidents'); ?>
<?php $__env->startSection('page_breadcrumb', 'Manage all security incidents'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
    <div class="flex flex-wrap items-center gap-2">
        <?php $__currentLoopData = [''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $count = match($val) {
            'pending'  => \App\Models\Incident::pending()->count(),
            'approved' => \App\Models\Incident::approved()->count(),
            'rejected' => \App\Models\Incident::where('status','rejected')->count(),
            default    => \App\Models\Incident::count(),
        }; ?>
        <a href="<?php echo e(route('admin.incidents.index')); ?><?php echo e($val ? '?status='.$val : ''); ?>"
           class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
                  <?php echo e(request('status') === $val || (request('status') === null && $val === '') ?
                     'bg-ng-green text-white border-ng-green' :
                     'bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green'); ?>">
            <?php echo e($label); ?>

            <span class="font-bold"><?php echo e($count); ?></span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <a href="<?php echo e(route('admin.incidents.create')); ?>" class="btn-primary inline-flex items-center gap-2 flex-shrink-0">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Incident
    </a>
</div>


<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <?php if(request('status')): ?>
        <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
        <?php endif; ?>
        <div class="flex-1 min-w-36">
            <label class="form-label text-xs">State</label>
            <select name="state_id" class="form-input text-xs py-2">
                <option value="">All States</option>
                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($state->id); ?>" <?php echo e(request('state_id') == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="flex-1 min-w-36">
            <label class="form-label text-xs">Attack Type</label>
            <select name="attack_type" class="form-input text-xs py-2">
                <option value="">All Types</option>
                <?php $__currentLoopData = $attackTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e(request('attack_type') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="flex-1 min-w-32">
            <label class="form-label text-xs">Severity</label>
            <select name="severity" class="form-input text-xs py-2">
                <option value="">All</option>
                <?php $__currentLoopData = ['low','medium','high','critical']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('severity') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="flex-1 min-w-40">
            <label class="form-label text-xs">Search</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   placeholder="Title, town..." class="form-input text-xs py-2">
        </div>
        <button type="submit" class="btn-primary text-xs py-2">Filter</button>
        <?php if(request()->hasAny(['state_id','attack_type','severity','search'])): ?>
        <a href="<?php echo e(route('admin.incidents.index')); ?><?php echo e(request('status') ? '?status='.request('status') : ''); ?>"
           class="text-xs text-gray-500 hover:text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">Clear</a>
        <?php endif; ?>
    </form>
</div>


<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Incident</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden sm:table-cell">Location</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden md:table-cell">Type</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Severity</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Status</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden lg:table-cell">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $incidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5 max-w-xs">
                        <div class="flex items-start gap-2">
                            <?php if($incident->is_featured): ?>
                            <span class="text-yellow-400 mt-0.5 flex-shrink-0">⭐</span>
                            <?php endif; ?>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 line-clamp-1"><?php echo e($incident->title); ?></p>
                                <p class="text-xs text-gray-400 mt-0.5">by <?php echo e($incident->creator?->full_name ?? 'Admin'); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <p class="text-xs font-medium text-gray-700"><?php echo e($incident->state->name); ?></p>
                        <?php if($incident->lga): ?><p class="text-[10px] text-gray-400"><?php echo e($incident->lga->name); ?></p><?php endif; ?>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($incident->attack_type_label); ?></span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg severity-<?php echo e($incident->severity); ?>">
                            <?php echo e(ucfirst($incident->severity)); ?>

                        </span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg status-<?php echo e($incident->status); ?>">
                            <?php echo e(ucfirst($incident->status)); ?>

                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500"><?php echo e($incident->incident_date?->format('d M Y')); ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.incidents.show', $incident)); ?>"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">View</a>
                            <a href="<?php echo e(route('admin.incidents.edit', $incident)); ?>"
                               class="text-xs font-semibold text-gray-500 hover:text-gray-700 transition-colors">Edit</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-14 text-gray-400 text-sm">
                        No incidents found matching your filters.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($incidents->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100">
        <?php echo e($incidents->withQueryString()->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/incidents/index.blade.php ENDPATH**/ ?>