<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('ticketit::shared.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $__env->make('ticketit::shared.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php if(View::hasSection('ticketit_content')): ?>
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                    <?php if(View::hasSection('page_title')): ?>
                        <span><?php echo $__env->yieldContent('page_title'); ?></span>
                    <?php else: ?>
                        <span><?php echo $__env->yieldContent('page'); ?></span>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('ticketit_header'); ?>
                </h5>
                <div class="card-body <?php echo $__env->yieldContent('ticketit_content_parent_class'); ?>">
                    <?php echo $__env->yieldContent('ticketit_content'); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('ticketit_extra_content'); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($master, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/layouts/master.blade.php ENDPATH**/ ?>