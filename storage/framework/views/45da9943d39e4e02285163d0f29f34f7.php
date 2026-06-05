<?php $__env->startSection('title', 'Edit: ' . Str::limit($incident->title, 40)); ?>
<?php $__env->startSection('page_title', 'Edit Incident'); ?>
<?php $__env->startSection('page_breadcrumb', 'Modify incident details'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.incidents._form', [
    'incident'    => $incident,
    'lgas'        => $lgas,
    'action'      => route('admin.incidents.update', $incident),
    'method'      => 'PUT',
    'states'      => $states,
    'attackTypes' => $attackTypes,
    'severities'  => $severities,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/admin/incidents/edit.blade.php ENDPATH**/ ?>