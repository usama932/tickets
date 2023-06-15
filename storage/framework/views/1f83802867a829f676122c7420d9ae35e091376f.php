<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <th class="text-center"><?php echo e(trans('ticketit::admin.table-hash')); ?></th>
        <th><?php echo e(trans('ticketit::admin.table-slug')); ?></th>
        <th><?php echo e(trans('ticketit::admin.table-default')); ?></th>
        <th><?php echo e(trans('ticketit::admin.table-value')); ?></th>
        <th class="text-center"><?php echo e(trans('ticketit::admin.table-lang')); ?></th>
        <th class="text-center"><?php echo e(trans('ticketit::admin.table-edit')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $configurations_by_sections['perms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $configuration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo $configuration->id; ?></td>
                <td><?php echo $configuration->slug; ?></td>
                <td><?php echo $configuration->default; ?></td>
                <td><a href="<?php echo route($setting->grab('admin_route').'.configuration.edit', [$configuration->id]); ?>" title="<?php echo e(trans('ticketit::admin.table-edit').' '.$configuration->slug); ?>" data-toggle="tooltip"><?php echo $configuration->value; ?></a></td>
                <td class="text-center"><?php echo $configuration->lang; ?></td>
                <td class="text-center">
                    <?php echo link_to_route(
                        $setting->grab('admin_route').'.configuration.edit', trans('ticketit::admin.btn-edit'), [$configuration->id],
                        ['class' => 'btn btn-info', 'title' => trans('ticketit::admin.table-edit').' '.$configuration->slug,  'data-toggle' => 'tooltip'] ); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/admin/configuration/tables/perms_table.blade.php ENDPATH**/ ?>