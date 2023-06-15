<?php $__env->startSection('page', trans('ticketit::admin.config-index-title')); ?>

<?php $__env->startSection('ticketit_header'); ?>
<?php echo link_to_route(
    $setting->grab('admin_route').'.configuration.create',
    trans('ticketit::admin.btn-create-new-config'), null,
    ['class' => 'btn btn-primary']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('ticketit_content_parent_class', 'pl-0 pr-0 pb-0'); ?>

<?php $__env->startSection('ticketit_content'); ?>
<!-- configuration -->
    <?php if($configurations->isEmpty()): ?>
        <div class="text-center"><?php echo e(trans('ticketit::admin.config-index-no-settings')); ?></div>
    <?php else: ?>
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#init-configs"><?php echo e(trans('ticketit::admin.config-index-initial')); ?></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ticket-configs"><?php echo e(trans('ticketit::admin.config-index-tickets')); ?></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#email-configs"><?php echo e(trans('ticketit::admin.config-index-notifications')); ?></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#perms-configs"><?php echo e(trans('ticketit::admin.config-index-permissions')); ?></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#editor-configs"><?php echo e(trans('ticketit::admin.config-index-editor')); ?></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#other-configs"><?php echo e(trans('ticketit::admin.config-index-other')); ?></a></li>
        </ul>

        <div class="tab-content">
            <div id="init-configs" class="tab-pane fade show active">
                <?php echo $__env->make('ticketit::admin.configuration.tables.init_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div id="ticket-configs" class="tab-pane fade">
                <?php echo $__env->make('ticketit::admin.configuration.tables.ticket_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div id="email-configs" class="tab-pane fade">
                <?php echo $__env->make('ticketit::admin.configuration.tables.email_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div id="perms-configs" class="tab-pane fade">
                <?php echo $__env->make('ticketit::admin.configuration.tables.perms_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div id="editor-configs" class="tab-pane fade">
                <?php echo $__env->make('ticketit::admin.configuration.tables.editor_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div id="other-configs" class="tab-pane fade">
                <?php echo $__env->make('ticketit::admin.configuration.tables.other_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php endif; ?>
<!-- // Configuration -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/admin/configuration/index.blade.php ENDPATH**/ ?>