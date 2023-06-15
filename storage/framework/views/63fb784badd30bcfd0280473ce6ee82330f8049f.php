<?php $__env->startSection('page', trans('ticketit::admin.administrator-index-title')); ?>

<?php $__env->startSection('ticketit_header'); ?>
<?php echo link_to_route(
    $setting->grab('admin_route').'.administrator.create',
    trans('ticketit::admin.btn-create-new-administrator'), null,
    ['class' => 'btn btn-primary']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('ticketit_content_parent_class', 'p-0'); ?>

<?php $__env->startSection('ticketit_content'); ?>
    <?php if($administrators->isEmpty()): ?>
        <h3 class="text-center"><?php echo e(trans('ticketit::admin.administrator-index-no-administrators')); ?>

            <?php echo link_to_route($setting->grab('admin_route').'.administrator.create', trans('ticketit::admin.administrator-index-create-new')); ?>

        </h3>
    <?php else: ?>
        <div id="message"></div>
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th><?php echo e(trans('ticketit::admin.table-id')); ?></th>
                <th><?php echo e(trans('ticketit::admin.table-name')); ?></th>
                <th><?php echo e(trans('ticketit::admin.table-remove-administrator')); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $administrators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $administrator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($administrator->id); ?>

                    </td>
                    <td>
                        <?php echo e($administrator->name); ?>

                    </td>
                    <td>
                        <?php echo CollectiveForm::open([
                        'method' => 'DELETE',
                        'route' => [
                                    $setting->grab('admin_route').'.administrator.destroy',
                                    $administrator->id
                                    ],
                        'id' => "delete-$administrator->id"
                        ]); ?>

                        <?php echo CollectiveForm::submit(trans('ticketit::admin.btn-remove'), ['class' => 'btn btn-danger']); ?>

                        <?php echo CollectiveForm::close(); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/admin/administrator/index.blade.php ENDPATH**/ ?>