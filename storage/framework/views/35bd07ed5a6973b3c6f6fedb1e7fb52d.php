<?php $__env->startSection('title', 'Manage Users'); ?>
<?php $__env->startSection('page_title', 'Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    
    <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap items-center gap-3">
        <form method="GET" class="flex flex-wrap gap-3 flex-1">
            <select name="role" class="form-input text-xs py-1.5 w-36" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <?php $__currentLoopData = ['super_admin'=>'Super Admin','moderator'=>'Moderator','user'=>'User']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e(request('role') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   placeholder="Name or email..." class="form-input text-xs py-1.5 flex-1 min-w-40">
            <button type="submit" class="btn-primary text-xs py-1.5 px-3">Search</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">User</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Role</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Reports</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Comments</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Joined</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="<?php echo e($user->avatar_url); ?>" class="w-8 h-8 rounded-full border border-gray-100 object-cover flex-shrink-0"
                                 alt="<?php echo e($user->full_name); ?>">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($user->full_name); ?></p>
                                <p class="text-xs text-gray-400 truncate"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            <?php echo e($user->role === 'super_admin' ? 'bg-purple-100 text-purple-700' :
                               ($user->role === 'moderator' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600')); ?>">
                            <?php echo e($user->role_label); ?>

                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($user->incidents_count); ?></span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600"><?php echo e($user->comments_count); ?></span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            <?php echo e($user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                            <?php echo e($user->is_active ? 'Active' : 'Suspended'); ?>

                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500"><?php echo e($user->created_at->format('d M Y')); ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2" x-data="{ open: false }">
                            <a href="<?php echo e(route('admin.users.show', $user)); ?>"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">View</a>
                            <div class="relative">
                                <button @click="open = !open" @click.outside="open = false"
                                        class="text-xs text-gray-400 hover:text-gray-600 transition-colors">⋯</button>
                                <div x-show="open"
                                     class="absolute right-0 mt-1 w-40 bg-white rounded-xl border border-gray-100 shadow-lg py-1 z-10">
                                    
                                    <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button class="w-full text-left text-xs px-3 py-2 hover:bg-gray-50 transition-colors
                                                       <?php echo e($user->is_active ? 'text-red-600' : 'text-green-600'); ?>">
                                            <?php echo e($user->is_active ? 'Suspend User' : 'Activate User'); ?>

                                        </button>
                                    </form>
                                    
                                    <?php $__currentLoopData = ['user'=>'Set as User','moderator'=>'Set as Moderator']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($user->role !== $role): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.change-role', $user)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="role" value="<?php echo e($role); ?>">
                                        <button class="w-full text-left text-xs px-3 py-2 text-gray-600 hover:bg-gray-50 transition-colors">
                                            <?php echo e($label); ?>

                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100"><?php echo e($users->withQueryString()->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/users/index.blade.php ENDPATH**/ ?>