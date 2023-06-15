<?php $__env->startSection('page', trans('ticketit::admin.category-index-title')); ?>

<?php $__env->startSection('ticketit_header'); ?>
<?php echo link_to_route(
    $setting->grab('admin_route').'.category.create',
    trans('ticketit::admin.btn-create-new-category'), null,
    ['class' => 'btn btn-primary']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('ticketit_content_parent_class', 'p-0'); ?>

<?php $__env->startSection('ticketit_content'); ?>
    <?php if($categories->isEmpty()): ?>
        <h3 class="text-center"><?php echo e(trans('ticketit::admin.category-index-no-categories')); ?>

            <?php echo link_to_route($setting->grab('admin_route').'.category.create', trans('ticketit::admin.category-index-create-new')); ?>

        </h3>
    <?php else: ?>
        <div id="message"></div>
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th><?php echo e(trans('ticketit::admin.table-id')); ?></th>
                    <th><?php echo e(trans('ticketit::admin.table-name')); ?></th>
                    <th><?php echo e(trans('ticketit::admin.table-action')); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="vertical-align: middle">
                        <?php echo e($category->id); ?>

                    </td>
                    <td style="color: <?php echo e($category->color); ?>; vertical-align: middle">
                        <?php echo e($category->name); ?>

                    </td>
                    <td>
                        <?php echo link_to_route(
                                                $setting->grab('admin_route').'.category.edit', trans('ticketit::admin.btn-edit'), $category->id,
                                                ['class' => 'btn btn-info'] ); ?>


                            <?php echo link_to_route(
                                                $setting->grab('admin_route').'.category.destroy', trans('ticketit::admin.btn-delete'), $category->id,
                                                [
                                                'class' => 'btn btn-danger deleteit',
                                                'form' => "delete-$category->id",
                                                "node" => $category->name
                                                ]); ?>

                        <?php echo CollectiveForm::open([
                                        'method' => 'DELETE',
                                        'route' => [
                                                    $setting->grab('admin_route').'.category.destroy',
                                                    $category->id
                                                    ],
                                        'id' => "delete-$category->id"
                                        ]); ?>

                        <?php echo CollectiveForm::close(); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        $( ".deleteit" ).click(function( event ) {
            event.preventDefault();
            if (confirm("<?php echo trans('ticketit::admin.category-index-js-delete'); ?>" + $(this).attr("node") + " ?"))
            {
                var form = $(this).attr("form");
                $("#" + form).submit();
            }

        });
    </script>
<?php $__env->appendSection(); ?>

<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/admin/category/index.blade.php ENDPATH**/ ?>