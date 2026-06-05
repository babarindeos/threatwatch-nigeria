<?php $__env->startSection('title', 'Moderate Comments'); ?>
<?php $__env->startSection('page_title', 'Comments'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap gap-2 mb-5">
    <?php $__currentLoopData = [''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.comments.index')); ?><?php echo e($val ? '?status='.$val : ''); ?>"
       class="text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
              <?php echo e(request('status') === $val || (request('status') === null && $val === '') ?
                 'bg-ng-green text-white border-ng-green' :
                 'bg-white text-gray-600 border-gray-200 hover:border-ng-green'); ?>">
        <?php echo e($label); ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50/50 transition-colors">
            <img src="<?php echo e($comment->user->avatar_url); ?>"
                 class="w-8 h-8 rounded-full border border-gray-100 flex-shrink-0 object-cover">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="text-sm font-bold text-gray-900"><?php echo e($comment->user->full_name); ?></span>
                    <span class="text-xs text-gray-400"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded
                        <?php echo e($comment->status === 'approved' ? 'bg-green-100 text-green-700' :
                           ($comment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')); ?>">
                        <?php echo e($comment->status); ?>

                    </span>
                    <?php if($comment->parent_id): ?>
                    <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-medium">Reply</span>
                    <?php endif; ?>
                </div>
                <p class="text-sm text-gray-700 line-clamp-2"><?php echo e($comment->comment); ?></p>
                <?php if($comment->incident): ?>
                <a href="<?php echo e(route('admin.incidents.show', $comment->incident)); ?>"
                   class="text-xs text-ng-green hover:text-ng-dark font-medium mt-1 inline-block transition-colors">
                    On: <?php echo e(Str::limit($comment->incident->title, 60)); ?> →
                </a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <?php if($comment->status !== 'approved'): ?>
                <form method="POST" action="<?php echo e(route('admin.comments.approve', $comment)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button class="text-xs font-bold text-green-600 hover:text-green-800 px-2 py-1 rounded-lg
                                   hover:bg-green-50 transition-colors">
                        ✓ Approve
                    </button>
                </form>
                <?php endif; ?>
                <?php if($comment->status !== 'rejected'): ?>
                <form method="POST" action="<?php echo e(route('admin.comments.reject', $comment)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button class="text-xs font-bold text-amber-600 hover:text-amber-800 px-2 py-1 rounded-lg
                                   hover:bg-amber-50 transition-colors">
                        ✕ Reject
                    </button>
                </form>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('admin.comments.destroy', $comment)); ?>"
                      onsubmit="return confirm('Delete this comment?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="text-xs text-red-400 hover:text-red-600 px-2 py-1 rounded-lg
                                   hover:bg-red-50 transition-colors">
                        🗑
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-14 text-gray-400 text-sm">No comments found.</div>
        <?php endif; ?>
    </div>
    <?php if($comments->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100"><?php echo e($comments->withQueryString()->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/comments/index.blade.php ENDPATH**/ ?>