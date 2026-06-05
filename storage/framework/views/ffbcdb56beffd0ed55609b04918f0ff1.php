
<?php if($paginator->hasPages()): ?>
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">

    
    <div class="flex flex-1 justify-between sm:hidden">
        <?php if($paginator->onFirstPage()): ?>
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                     bg-white border border-gray-200 rounded-xl cursor-not-allowed">
            ← Previous
        </span>
        <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>"
           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700
                  bg-white border border-gray-200 rounded-xl hover:border-ng-green hover:text-ng-green transition-colors">
            ← Previous
        </a>
        <?php endif; ?>

        <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>"
           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700
                  bg-white border border-gray-200 rounded-xl hover:border-ng-green hover:text-ng-green transition-colors">
            Next →
        </a>
        <?php else: ?>
        <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                     bg-white border border-gray-200 rounded-xl cursor-not-allowed">
            Next →
        </span>
        <?php endif; ?>
    </div>

    
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500">
                Showing
                <span class="font-semibold text-gray-900"><?php echo e($paginator->firstItem()); ?></span>
                to
                <span class="font-semibold text-gray-900"><?php echo e($paginator->lastItem()); ?></span>
                of
                <span class="font-semibold text-gray-900"><?php echo e($paginator->total()); ?></span>
                results
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                
                <?php if($paginator->onFirstPage()): ?>
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300
                             bg-white border-r border-gray-200 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </span>
                <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>"
                   class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600
                          bg-white border-r border-gray-200 hover:bg-ng-muted hover:text-ng-green transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400
                                 bg-white border-r border-gray-200">
                        <?php echo e($element); ?>

                    </span>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold
                                         text-white bg-ng-green border-r border-ng-dark z-10"
                                  aria-current="page">
                                <?php echo e($page); ?>

                            </span>
                            <?php else: ?>
                            <a href="<?php echo e($url); ?>"
                               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600
                                      bg-white border-r border-gray-200 hover:bg-ng-muted hover:text-ng-green transition-colors">
                                <?php echo e($page); ?>

                            </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>"
                   class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600
                          bg-white hover:bg-ng-muted hover:text-ng-green transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                <?php else: ?>
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300
                             bg-white cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>