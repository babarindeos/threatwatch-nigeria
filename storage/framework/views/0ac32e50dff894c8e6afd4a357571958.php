<?php $__env->startSection('title', 'User Reports'); ?>
<?php $__env->startSection('page_title', 'User-Submitted Reports'); ?>
<?php $__env->startSection('page_breadcrumb', 'Review and process community threat reports'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex flex-wrap items-center gap-2 mb-5">
    <?php $__currentLoopData = [''=>'All', 'pending'=>'Pending', 'reviewed'=>'Reviewed', 'approved'=>'Approved', 'rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.reports.index')); ?><?php echo e($val ? '?status='.$val : ''); ?>"
       class="text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
              <?php echo e(request('status') === $val || (request('status') === null && $val === '') ?
                 'bg-ng-green text-white border-ng-green' :
                 'bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green'); ?>">
        <?php echo e($label); ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Report</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Location</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Type</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Reporter</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5 max-w-xs">
                        <p class="text-sm font-semibold text-gray-900 line-clamp-1"><?php echo e($report->title); ?></p>
                        <?php if($report->casualties > 0 || $report->kidnapped_count > 0): ?>
                        <p class="text-[10px] text-gray-400 mt-0.5">
                            <?php if($report->casualties > 0): ?> <?php echo e($report->casualties); ?> killed <?php endif; ?>
                            <?php if($report->kidnapped_count > 0): ?> · <?php echo e($report->kidnapped_count); ?> kidnapped <?php endif; ?>
                        </p>
                        <?php endif; ?>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <p class="text-xs text-gray-700"><?php echo e($report->state->name); ?></p>
                        <?php if($report->town): ?><p class="text-[10px] text-gray-400"><?php echo e($report->town); ?></p><?php endif; ?>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($report->attack_type_label); ?></span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg <?php echo e($report->status_badge); ?>">
                            <?php echo e(ucfirst($report->status)); ?>

                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500"><?php echo e($report->display_name); ?></span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500"><?php echo e($report->incident_date?->format('d M Y')); ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <a href="<?php echo e(route('admin.reports.show', $report)); ?>"
                           class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">
                            Review →
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">No reports found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($reports->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100"><?php echo e($reports->withQueryString()->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>