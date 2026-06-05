<?php $__env->startSection('title', 'Manage Helplines'); ?>
<?php $__env->startSection('page_title', 'Helplines'); ?>
<?php $__env->startSection('page_breadcrumb', 'Manage emergency contact numbers'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-5">
    <div class="flex flex-wrap gap-2">
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="category" class="form-input text-xs py-1.5 w-40" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e(request('category') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="state_id" class="form-input text-xs py-1.5 w-44" onchange="this.form.submit()">
                <option value="">All (incl. National)</option>
                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($state->id); ?>" <?php echo e(request('state_id') == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>
    <a href="<?php echo e(route('admin.helplines.create')); ?>" class="btn-primary inline-flex items-center gap-2 flex-shrink-0">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Helpline
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Agency</th>
                    <th class="text-left px-3 py-3">Phone</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Category</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">State</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $helplines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <span class="text-lg"><?php echo e($line->category_icon); ?></span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($line->agency_name); ?></p>
                                <?php if($line->is_national): ?>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">National</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5">
                        <div>
                            <p class="text-sm font-mono font-semibold text-gray-900"><?php echo e($line->phone); ?></p>
                            <?php if($line->phone_alt): ?><p class="text-xs font-mono text-gray-400"><?php echo e($line->phone_alt); ?></p><?php endif; ?>
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($line->category_label); ?></span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($line->state?->name ?? '🇳🇬 National'); ?></span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            <?php echo e($line->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                            <?php echo e($line->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.helplines.edit', $line)); ?>"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.helplines.destroy', $line)); ?>"
                                  onsubmit="return confirm('Delete this helpline?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-xs text-red-400 hover:text-red-600 transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">No helplines found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($helplines->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100"><?php echo e($helplines->withQueryString()->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/helplines/index.blade.php ENDPATH**/ ?>